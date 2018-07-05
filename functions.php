<?php

function gc_projects($config) {
  
  $projects = [];
  $params = array('account_id' => $config['account_id']);
  $r = gathercontent('projects', $params, $config);
  foreach ($r['data'] as $project) {
        
    $p = [
      'name' => $project['name'],
      'statuses' => $project['statuses']['data']
    ];
    $projects[$project['id']] = $p;
    
  }
  return $projects;
  
}

function gc_project_items($pid, $config) {
  
  $items = [];
  
  $params = array('project_id' => $pid);
  $r = gathercontent('items', $params, $config);
  foreach ($r['data'] as $project_item) {
    
    // ignore anything with no template
    if (is_null($project_item['template_id'])) continue;
    
    $i = [
      'name'     => $project_item['name'],
      'template' => $project_item['template_id']
    ];
    
    $status = end($project_item['status']);
    $i['status'] = $status['name'];

    $items[$project_item['id']] = $i;
    
  }  
  
  return $items;
  
}

function gc_templates($pid, $config) {
  
  $templates = [];
  
  $params = array('project_id' => $pid);
  $r = gathercontent('templates', $params, $config);  
  foreach ($r['data'] as $template) {
    $templates[$template['id']] = $template['name'];
  }
  
  return $templates;
  
}

function gathercontent($function, $params, $cfg) {

  $httpheader = array('Accept: application/vnd.gathercontent.v0.5+json');
  $up         = $cfg['username'] . ':' . $cfg['apikey'];
  
  $url  = 'https://api.gathercontent.com/';
  $url .= $function;
  if ($params) {
    $ps = array();
    foreach ($params as $pk => $pv) {
      $ps[] = $pk . '=' . $pv;
    }
    $url .= '?' . implode('&', $ps);
  }
  
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $httpheader);
  curl_setopt( $ch, CURLOPT_USERPWD, $up);
  curl_setopt( $ch, CURLOPT_URL, $url);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
  $response = json_decode( curl_exec( $ch ), TRUE );
  curl_close( $ch );  
  
  return $response;
  
}