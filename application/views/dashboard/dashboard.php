    <section class="content-header">
      		<h1>Dashboard</h1>
    	</section>

    	<section class="content">
      		<div class="row">
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('berita');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Berita</p>
                  </div>
                  <a href="<?php echo site_url('akademik/berita'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('jadwal');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Jadwal Mengajar</p>
                  </div>
                  <a href="<?php echo site_url('akademik/jadwal'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('kelas');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Kelas</p>
                  </div>
                  <a href="<?php echo site_url('akademik/kelas'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('mapel');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Mata Pelajaran</p>
                  </div>
                  <a href="<?php echo site_url('akademik/mapel'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('siswa');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Siswa</p>
                  </div>
                  <a href="<?php echo site_url('akademik/siswa'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        		<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
            			<div class="inner">
              				<h3>
                      <?php
                      $this->db->from('buku');
                      echo $this->db->count_all_results();
                      ?>
                      </h3>
							<p>Data Buku</p>
            			</div>
            			<a href="<?php echo site_url('perpustakaan/buku'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>
            <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
                  <div class="inner">
                      <h3>
                      <?php
                      $this->db->from('ebook');
                      echo $this->db->count_all_results();
                      ?></h3>
              <p>Data Ebook</p>
                  </div>
                  <a href="<?php echo site_url('perpustakaan/ebook'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
				    <div class="col-lg-3 col-xs-6">
					<div class="small-box bg-red">
            			<div class="inner">
              				<h3>
                      <?php
                      $this->db->from('kategori');
                      echo $this->db->count_all_results();
                      ?></h3>
							<p>Data Kategori</p>
            			</div>
            			<a href="<?php echo site_url('perpustakaan/kategori'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>
			</div>
		</section>