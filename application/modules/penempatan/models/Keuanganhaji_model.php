<?php
	class Keuanganhaji_model extends CI_Model{

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_penempatan(){
			
			$SQL ='SELECT * FROM penempatan';		
			
			return $this->datatable->LoadJson($SQL);
			
		}

		// get all users for server-side datatable processing (ajax based)
		public function get_all_penempatan($kategori, $jenis_penempatan, $tahun, $lembaga, $quartal){			
	
			$this->db->select('*, ((p.estimasi_return*p.pokok_penempatan/100)+p.pokok_penempatan) as total_penempatan, QUARTER(p.tgl_transaksi) as quartal, YEAR(tgl_transaksi) as tahun, DATEDIFF(p.tgl_transaksi,p.tgl_jatuh_tempo) as sisa_hari');

			$this->db->from('penempatan p');
			$this->db->join('jenis_penempatan jp', 'p.jenis_penempatan = jp.id', 'left');
			$this->db->where('jp.slug', $jenis_penempatan);
			$this->db->where('p.kategori', $kategori);
			if ($tahun != 'all') {
				$this->db->where('p.tahun', $tahun );
			}
			if ($lembaga != 'all') {
				$this->db->where('p.lembaga', $lembaga);
			}
			if ($quartal != 'all') {
				$this->db->where('p.tgl_transaksi', $quartal);
			}

			$this->db->order_by('p.tgl_transaksi', 'ASC');

			$query = $this->db->get();
			return $result = $query->result_array();
		
		}


		// get all users for server-side datatable processing (ajax based)
		public function get_grafik($kategori, $jenis_penempatan, $tahun, $lembaga, $quartal){			
	
			$this->db->select('*, ((p.estimasi_return*p.pokok_penempatan/100)+p.pokok_penempatan) as total_penempatan, QUARTER(p.tgl_transaksi) as quartal, YEAR(tgl_transaksi) as tahun, DATEDIFF(p.tgl_transaksi,p.tgl_jatuh_tempo) as sisa_hari');

			$this->db->from('penempatan p');
			$this->db->join('jenis_penempatan jp', 'p.jenis_penempatan = jp.id', 'left');
			$this->db->where('jp.slug', $jenis_penempatan);
			$this->db->where('p.kategori', $kategori);
			if ($tahun != 'all') {
				$this->db->where('p.tahun', $tahun );
			}
			if ($lembaga != 'all') {
				$this->db->where('p.lembaga', $lembaga);
			}
			if ($quartal != 'all') {
				$this->db->where('p.tgl_transaksi', $quartal);
			}

			$this->db->group_by('tahun');

			$query = $this->db->get();
			return $result = $query->result_array();
		
		}

		// get total penjumlahan investasi
		public function get_total_return($kategori, $jenis_penempatan, $tahun, $lembaga, $quartal){			
	
			$this->db->select('SUM(pokok_penempatan*estimasi_return/100+pokok_penempatan) as pokok_estimasi, SUM(pokok_penempatan) as pokok_penempatan');

			$this->db->from('penempatan p');
			$this->db->join('jenis_penempatan jp', 'p.jenis_penempatan = jp.id', 'left');
			$this->db->where('jp.slug', $jenis_penempatan);
			$this->db->where('p.kategori', $kategori);

			if ($tahun != 'all') {
				$this->db->where('p.tahun', $tahun );
			}
			if ($lembaga != 'all') {
				$this->db->where('p.lembaga', $lembaga);
			}
			if ($quartal != 'all') {
				$this->db->where('p.periode', $quartal);
			}

			$query = $this->db->get();
			return $result = $query->row_array();
		
		}


	
	}

?>