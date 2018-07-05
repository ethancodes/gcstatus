<?php include 'proto_head.php'; ?>

<div class="container">
  <h1><?php echo $project['name']; ?></h1>
</div>

<div class="container">

<?php if ($project): ?>
  
  <?php
    // calculate the status percentages
    $status_percentages = [];
    $num_statuses = count($project['statuses']);
    foreach ($project['statuses'] as $i => $s) {
      $status_percentages[$s['name']] = round(($i / ($num_statuses-1)) * 100, 2);
    }  
  ?>
  
  <?php
    // get all the project items
    $project_items = gc_project_items($project_id, $cfg);
  
    $item_percentages = [];
    foreach ($project_items as $piid => $pi) {
      $item_percentages[$piid] = $status_percentages[$pi['status']];      
    }
  ?>
  
  <?php
    // get all the templates
    $templates = gc_templates($project_id, $cfg);
  ?>
  
  <?php
    // so we would be at 100% if
    // total item percentages = number of items * 100
    $complete = count($item_percentages) * 100;
    $total = 0;
    foreach ($item_percentages as $piid => $p) {
      $total += $p;
    }
    if ($total) {
      $total_percent = round(($total / $complete) * 100);
    } else {
      $total_percent = 0;
    }
  ?>  
  
  <?php // ?>
  
  
  <hr />
  
  <div class="row">
    <div class="col-6">
      <h3>Overview</h3>
      <p>
        <strong>Items:</strong> <?php echo count($project_items); ?><br />
        <strong>Templates:</strong> <?php echo count($templates); ?><br />
        <strong>Content is at <?php echo $total_percent; ?>%</strong>
      </p>
    </div>
    <div class="set-size charts-container col-6">
      <div class="pie-wrapper progress-<?php echo $total_percent; ?>">
        <span class="label">
          <?php echo $total_percent; ?>
          <span class="smaller">%</span>
        </span>
        <div class="pie">
          <div class="left-side half-circle"></div>
          <div class="right-side half-circle"></div>
        </div>
      </div>
    </div>    
  </div>
  

  
  
  
  <hr />
  <h3>Status Breakdown</h3>
  <ul class="list-group">
    <?php foreach ($project['statuses'] as $ps): ?>
    <li class="list-group-item">
      <i class="fa fa-circle" style="color: <?php echo $ps['color']; ?>"></i>
      <strong><?php echo $ps['name']; ?></strong>
      has 
      <?php 
        $items_with_this_status = 0;
        foreach ($project_items as $pi) {
          if ($pi['status'] == $ps['name']) $items_with_this_status++;
        }
        echo $items_with_this_status;
      ?>
      item<?php if ($items_with_this_status != 1) echo 's'; ?>
    </li>
    <?php endforeach; ?>
  </ul>
  
  
  <hr />
  <h3>Status By Template</h3>
  <ul class="list-group">
    <?php foreach ($templates as $tid => $tname): ?>
    <li class="list-group-item">
      <strong><?php echo $tname; ?></strong>
      has
      <?php
        $num_items = 0;
        $template_items = [];
        foreach ($project_items as $piid => $pi) {
          if ($pi['template'] == $tid) {
            $num_items++;
            $template_items[] = $piid;
          }
        }
        echo $num_items;
      ?>
      item<?php if ($num_items != 1) echo 's'; ?>
      and content is at
      <?php
      $complete = $num_items * 100;
      $total = 0;
      foreach ($item_percentages as $piid => $p) {
        if (in_array($piid, $template_items)) {
          $total += $p;
        }
      }
      if ($total) {
        echo round(($total / $complete) * 100) . '%';
      } else {
        echo 'ZERO';
      }
      ?>
    </li>
    <?php endforeach; ?>
  </ul>
        
<?php else: ?>
  <h3>Select a project from the menu</h3>

<?php endif; /* pid */ ?>
  
</div>

<?php include 'proto_foot.php'; ?>