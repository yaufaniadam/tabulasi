<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
require_once APPPATH."/third_party/PHPExcel/PHPExcel.php";
  
class Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
       

    }
    public function style($style) {   
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		
		$style_header = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			 ),
			'fill' => array(
		        'type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'color' => array('rgb' => 'd6e8e7')
		    ),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		

		$style_td = array(
		  	'alignment' => array(
		  		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // Set text jadi di tengah secara vertical (middle)
		    	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  	),
		  	'borders' => array(
			    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
		  	)
		);

		$style_td_left = array(
		  	'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, // Set text jadi di tengah secara vertical (middle)
			   	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
		);

			
		$style_td_bold = array(
		  	'font' => array('bold' => true),
			  	'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => 'a1f39d')
	        ),
		);


		$arr = array('style_header'=>$style_header, 'style_td'=>$style_td, 'style_td_left'=>$style_td_left, 'style_td_bold'=>$style_td_bold );

		return $arr[$style];

	}
	 
}