<section class="sidebar">
      <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/dist/img/avatar5.png'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata("nama_lengkap"); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
      
      <ul class="sidebar-menu" data-widget="tree">
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right"></span>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="<?php echo site_url('dashboard');?>"><i class="fa fa-circle-o"></i> Dashboard</a></li>
            </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Akademik</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('akademik/berita');?>"><i class="fa fa-circle-o"></i> Data Berita</a></li>
              <li><a href="<?php echo site_url('akademik/kelas');?>"><i class="fa fa-circle-o"></i> Data Kelas</a></li>
              <li><a href="<?php echo site_url('akademik/jadwal');?>"><i class="fa fa-circle-o"></i> Data Jadwal Mengajar</a></li>
              <li><a href="<?php echo site_url('akademik/mapel');?>"><i class="fa fa-circle-o"></i> Data Mata Pelajaran</a></li>
			  <li><a href="<?php echo site_url('akademik/siswa');?>"><i class="fa fa-circle-o"></i> Data Siswa</a></li>
            </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Perpustakaan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('perpustakaan/buku');?>"><i class="fa fa-circle-o"></i> Data Buku</a></li>
			  <li><a href="<?php echo site_url('perpustakaan/ebook');?>"><i class="fa fa-circle-o"></i> Data Ebook</a></li>
              <li><a href="<?php echo site_url('perpustakaan/kategori');?>"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
            </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-pencil"></i>
            <span>Absensi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url('absensi/siswa');?>"><i class="fa fa-circle-o"></i> Data Absensi Siswa</a></li>
			  <li><a href="<?php echo site_url('absensi/guru');?>"><i class="fa fa-circle-o"></i> Data Absensi Guru</a></li>
            </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i> <span>Kalender</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="<?php echo site_url('calendar');?>"><i class="fa fa-circle-o"></i> Kalender Event</a></li>
            </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li><a href="#" onclick="return confirm('Masih dalam tahap pengembangan')"><i class="fa fa-circle-o"></i> Laporan PSB</a></li>
			  <li><a href="#" onclick="return confirm('Masih dalam tahap pengembangan')"><i class="fa fa-circle-o"></i> Laporan Absensi</a></li>
        <li><a href="#" onclick="return confirm('Masih dalam tahap pengembangan')"><i class="fa fa-circle-o"></i> Laporan Peminjaman Buku</a></li>
            </ul>
        </li>
      </ul>
    </section>