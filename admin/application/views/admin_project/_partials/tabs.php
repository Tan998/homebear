<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<ul class="nav nav-tabs mb-4">
<?php foreach ($categories as $c): ?>
  <li class="nav-item">
    <a class="nav-link <?= $c->id == $category->id ? 'active' : '' ?>"
       href="<?= site_url('Project_Manager/index/'.$c->category_key) ?>">
       <?= $c->category_name ?>
    </a>
  </li>
<?php endforeach; ?>
</ul>
