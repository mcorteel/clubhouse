<?php

include_once 'controller.php';

class AdminStatisticsController extends Controller
{
    public function index()
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'admin');
        
        $data = array(
            'reservations' => array(
                'config' => array(
                    'min_hour' => $this->getConfig('reservation_min_hour'),
                    'max_hour' => $this->getConfig('reservation_max_hour'),
                ),
            ),
        );
        
        $hours = $this->query('SELECT HOUR(date_start) AS hour, COUNT(*) AS count FROM reservations GROUP BY HOUR(date_start) ORDER BY COUNT(*) DESC');
        foreach($hours as $hour) {
            $data['reservations']['hours'][$hour['hour']] = $hour['count'];
        }
        
        $data['users']['count'] = $this->querySingleScalar('SELECT COUNT(*) FROM users');
        
        return $this->render('admin/statistics/index.php', $data);
    }
}
