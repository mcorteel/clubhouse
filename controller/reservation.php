<?php

include_once 'controller.php';

class ReservationController extends Controller
{
    private function getReservationDetails($reservation, $resource = false)
    {
        $reservation = array_merge($reservation, array(
            'players' => $this->query('SELECT rp.team AS team, u.first_name AS first_name, u.last_name AS last_name, rp.guest_name AS guest_name, u.id AS id FROM reservation_players rp LEFT JOIN users u ON rp.user = u.id WHERE rp.reservation = ? ORDER BY rp.team', array($reservation['id'])),
        ));
        if($resource) {
            $reservation['resource'] = $this->querySingle('SELECT * FROM resources WHERE id = ?', array($reservation['resource']));
        }
        return $reservation;
    }
    
    private function getScoreDetails($score)
    {
        if(!$score) {
            return null;
        }
        $score = explode(' ', $score);
        $aWins = 0;
        $bWinw = 0;
        foreach($score as $i => $set) {
            $set = explode('/', $set);
            $break = null;
            if(strlen($set[1]) > 1) {
                $break = substr($set[1], 2, -1);
                $set[1] = substr($set[1], 0, 1);
            }
            
            // NOTE This is really bad
            $aWins += $set[0] > $set[1];
            $bWins += $set[0] < $set[1];
            $score[$i] = array(
                'A' => $set[0],
                'B' => $set[1],
                'break' => $break,
                'wins' => $set[0] > $set[1] ? 'A' : 'B',
            );
        }
        return array(
            'wins' => $aWins > $bWins ? 'A' : 'B',
            'sets' => $score
        );
    }
    
    private function getReservationTypes()
    {
        return include 'config/reservation_types.php';
    }
    
    public function index($date = null)
    {
        if($date === null) {
            $date = new DateTime((int)date('G') > 19 ? 'tomorrow' : 'now');
        } else {
            $date = new DateTime($date);
        }
        
        $resources = $this->query('SELECT * FROM resources ORDER BY group_name, name');
        
        foreach($resources as $i => $resource) {
            $reservations = $this->query('SELECT r.* FROM reservations r WHERE (DATE(r.date_start) = :date OR DATE(r.date_start) <= :date AND DATE(COALESCE(r.date_end, :date)) >= :date AND r.recurrence IS NOT NULL AND (r.recurrence = "weekly" AND MOD(DATEDIFF(:date, r.date_start), 7) = 0 OR r.recurrence = "daily")) AND r.resource = :resource', array('date' => $date->format('Y-m-d'), 'resource' => $resource['id']));
            $_reservations = array();
            
            foreach($reservations as $reservation) {
                $start = new DateTime($reservation['date_start']);
                $_reservations[(int)$start->format('G') * 60 + (int)$start->format('i')] = $this->getReservationDetails($reservation);
            }
            $resources[$i]['reservations'] = $_reservations;
        }
        
        return $this->render('reservation/index.php', array(
            'date' => $date,
            'resources' => $resources,
            'canCreate' => $this->isGranted($this->getUser(), 'reservation'),
            'message' => $this->getConfig('reservation_message'),
            'minHour' => $this->getConfig('reservation_min_hour'),
            'maxHour' => $this->getConfig('reservation_max_hour'),
            'types' => $this->getReservationTypes(),
            'subdivision' => (int)$this->getConfig('reservation_subdivision'),
        ));
    }
    
    public function create()
    {
        $user = $this->getUser();
        
        $this->denyAccessUnlessGranted($user, 'reservation');
        
        $time = new DateTime($_GET['time']);
        $admin = $this->isGranted($user, 'reservation_admin');
        if(bccomp($time->format('YmdHi'), date('YmdHi')) < 0) {
            return $this->redirectTo('/reservation/' . $time->format('Y-m-d'));
        }
        
        $types = array();
        foreach($this->getReservationTypes() as $key => $_type) {
            if($this->isGranted($user, $_type['permissions'])) {
                $types[$key] = $_type;
            }
        }
        
        if(!$admin) {
            $type = $types[$user['reservation_type']];
        }
        $configOverride = isset($type['config']) ? $type['config'] : array();
        
        $subdivision = (int)$this->getConfig('reservation_subdivision');
        $maxDuration = $admin ? (24 * 60 - (int)$time->format('G') * 60 - (int)$time->format('i')) : $this->getConfig('reservation_max_duration', $configOverride) * $subdivision;
        $maxDuration = min($this->getConfig('reservation_max_hour', $configOverride) * 60 - (int)$time->format('G') * 60 - (int)$time->format('i'), $maxDuration);
        
        $reservations = $this->query('SELECT r.* FROM reservation_players rp JOIN reservations r ON rp.reservation = r.id WHERE rp.user = ? AND r.date_start > NOW()', array($user['id']));
        $authorized = $admin || count($reservations) < $this->getConfig('reservation_limit', $configOverride);
        $includeSelf = $this->getConfig('reservation_include_self', $configOverride);
        $allowGuests = $this->getConfig('reservation_allow_guests', $configOverride);
        $allowPlayers = $this->getConfig('reservation_allow_players', $configOverride, true);
        
        $resource = $this->querySingle('SELECT * FROM resources WHERE id = ?', array($_GET['resource']));
        
        if($authorized && isset($_POST['duration'])) {
            $_POST['players'] = isset($_POST['players']) ? $_POST['players'] : array();
            if($admin) {
                $endDate = new DateTime($_POST['date_end']);
            }
            $rId = $this->insert('reservations', array(
                'type' => $admin ? $_POST['type'] : $user['reservation_type'],
                'user' => $user['id'],
                'resource' => $resource['id'],
                'date_start' => $time->format('Y-m-d H:i:00'),
                'duration' => min($maxDuration, (int)$_POST['duration']),
                'created_at' => date('Y-m-d H:i:s'),
                'recurrence' => $admin ? $_POST['recurrence'] : null,
                'date_end' => $admin ? $endDate->format('Y-m-d 12:00:00') : null,
            ));
            $pCount = count($_POST['players']);
            
            $i = 0;
            foreach($_POST['players'] as $uId) {
                $pId = $this->insert('reservation_players', array(
                    'reservation' => $rId,
                    'user' => $uId,
                    'team' => $i++ < $pCount / 2 ? 'A' : 'B',
                ));
            }
            
            foreach($_POST['guest'] as $name) {
                $pId = $this->insert('reservation_players', array(
                    'reservation' => $rId,
                    'guest_name' => $name,
                    'team' => $i++ < $pCount / 2 ? 'A' : 'B',
                ));
            }
            
            return $this->redirectTo('/reservation/' . $time->format('Y-m-d'));
        }
        
        return $this->renderModal('reservation/create.php', array(
            'resource' => $resource,
            'time' => $time,
            'subdivision' => $subdivision,
            'maxDuration' => $maxDuration,
            'includeSelf' => $includeSelf,
            'allowGuests' => $allowGuests,
            'allowPlayers' => $allowPlayers,
            'reservations' => $reservations,
            'authorized' => $authorized,
            'players' => $this->query('SELECT u.id, u.first_name, u.last_name FROM users u WHERE (SELECT COUNT(DISTINCT r.id) FROM reservation_players rp JOIN reservations r ON rp.reservation = r.id WHERE rp.user = u.id AND r.date_start > NOW()) < ? ORDER BY u.last_name, u.first_name', array((int)$this->getConfig('reservation_limit'))),
            'admin' => $admin,
            'minPlayers' => (int)$this->getConfig('reservation_min_players', $configOverride),
            'maxPlayers' => (int)$this->getConfig('reservation_max_players', $configOverride),
            'types' => $types,
        ));
    }
    
    public function show($id)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'user');
        
        $reservation = $this->getReservationDetails($this->querySingle('SELECT * FROM reservations WHERE id = ?', array($id)), true);
        
        return $this->renderModal('reservation/show.php', array(
            'reservation' => $reservation,
            'score' => $this->getScoreDetails($reservation['score']),
            'subdivision' => (int)$this->getConfig('reservation_subdivision'),
        ));
    }
    
    public function cancel($id)
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'reservation');
        
        $reservation = $this->querySingle('SELECT * FROM reservations WHERE id = ?', array($id));
        $time = new DateTime($reservation['date_start']);
        
        if($reservation['user'] !== $user['id']) {
            return $this->denyAccess();
        }
        
        if((int)$time->format('YmdH') < (int)date('YmdH')) {
            return $this->denyAccess();
        }
        
        $this->delete('reservations', array('id' => $reservation['id']));
        
        return $this->redirectTo('/reservation/' . $time->format('Y-m-d'));
    }
}
