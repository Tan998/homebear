<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= site_url('admin/dashboard') ?>"><img src="<?php echo base_url(); ?>assets/img/logo_brand/HOMEBEAR.webp" alt="logo" width="100" class="shadow-light"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= site_url('admin/dashboard') ?>">HB</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?php echo $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('admin/dashboard') ?>"><i class="far fa-square"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">LOGO</li>
            <li class="<?php echo $this->uri->segment(1) == 'logo_manager' || $this->uri->segment(1) == 'logo_manager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('logo_manager/index') ?>"><i class="fa fa-file-image"></i> <span>Logo Manager</span></a></li>

            <li class="menu-header">Font Text</li>
            <li class="<?php echo $this->uri->segment(1) == 'FontTextManager' || $this->uri->segment(1) == 'FontTextManager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('FontTextManager/index') ?>"><i class="fa fa-file-image"></i> <span>Font Text Manager</span></a></li>

            <li class="menu-header">Top Background Video/Image</li>
            <li class="<?php echo $this->uri->segment(2) == 'VideoList' || $this->uri->segment(2) == 'VideoCreate' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('video_manager/VideoList') ?>"><i class="fa fa-file-image"></i> <span>Background Video Manager</span></a></li>
            <li class="<?php echo $this->uri->segment(2) == 'topbackgroundimg_index' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('hp_topbackgroundimg/topbackgroundimg_index') ?>"><i class="fa fa-file-image"></i> <span>Background Image Manager</span></a></li>

            <li class="menu-header">Top News</li>
            <li class="<?php echo $this->uri->segment(1) == 'news_manager' || $this->uri->segment(1) == 'news_manager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('news_manager/index') ?>"><i class="fa fa-file-image"></i> <span>News Manager</span></a></li>

            <!--<li class="menu-header">Company Profile Setting</li>
            <li class="<?php echo $this->uri->segment(2) == 'CompanyProfileManager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('company_profile/CompanyProfileManager') ?>"><i class="far fa-square"></i> <span>Company Profile Setting</span></a></li>-->

            <li class="menu-header">Company Profile Setting VER 2</li>
            <li class="<?php echo $this->uri->segment(1) == 'Company_Profile_Manager_Ver2' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('Company_Profile_Manager_Ver2/index') ?>"><i class="far fa-square"></i> <span>Company Profile Setting VER 2</span></a></li>
            
            <li class="menu-header">Projects Page Manager</li>
            <li class="<?php echo $this->uri->segment(1) == 'Project_Manager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('Project_Manager/index') ?>"><i class="far fa-square"></i> <span>Projects Page Manager</span></a></li>
            

            <!--<li class="menu-header">Posts</li>
            <li class="<?php echo $this->uri->segment(2) == 'PostsListManage' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('post/PostsListManage') ?>"><i class="fa fa-newspaper"></i> <span>Posts Manager</span></a></li>-->

            <!--<li class="menu-header">Contacts</li>
            <li class="<?php echo $this->uri->segment(2) == 'ContactManager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('contact/ContactManager') ?>"><i class="fa fa-phone"></i> <span>Contacts Manager</span></a></li>

            <li class="menu-header">Download Materials</li>
            <li class="<?php echo $this->uri->segment(2) == 'Download_Materials_Manager' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('download_materials/Download_Materials_Manager') ?>"><i class="fa fa-download"></i> <span>Download Materials Manager</span></a></li>

            <li class="menu-header">Black List Setting</li>
            <li class="<?php echo $this->uri->segment(2) == 'BlackListManage' ? 'active' : ''; ?>"><a class="nav-link" href="<?= site_url('black_list/BlackListManage') ?>"><i class="fa fa-download"></i> <span>Black List Manager</span></a></li>-->
          </ul>
        </aside>
      </div>
