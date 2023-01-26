<?php

include_once 'controller.php';

class AdminStatisticsController extends Controller
{
    public function index()
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'admin');
        
        $data = array(
            'reservations' => array(
                'hours' => array(),
                'weeks' => array(),
                'resources' => array(),
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
        
        $weeks = $this->query('SELECT YEARWEEK(date_start) AS week, COUNT(*) AS count FROM reservations GROUP BY YEARWEEK(date_start) ORDER BY COUNT(*) DESC');
        foreach($weeks as $week) {
            $data['reservations']['weeks'][$week['week']] = $week['count'];
        }
        
        $resources = $this->query('SELECT resource AS id, COUNT(*) AS count FROM reservations GROUP BY resource ORDER BY COUNT(*) DESC');
        foreach($resources as $resource) {
            $name = $this->querySingleScalar('SELECT name FROM resources WHERE id = ?', array($resource['id']));
            $data['reservations']['resources'][$name] = $resource['count'];
        }
        
        $data['users']['count'] = $this->querySingleScalar('SELECT COUNT(*) FROM users');
        
        return $this->render('admin/statistics/index.php', $data);
    }
}
