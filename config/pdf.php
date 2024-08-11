<?php
return [
	'mode'                 => 'utf-8',
	'format'               => 'A4',
	'default_font_size'    => '14',
	'default_font'         => 'sans-serif',
	'margin_left'          => 1,
	'margin_right'         => 10,
	'margin_top'           => 10,
	'margin_bottom'        => 10,
	'margin_header'        => 0,
	'margin_footer'        => 0,
	'orientation'          => 'P',
	'title'                => 'Laravel mPDF',
	'author'               => 'Fakhrul Islam',
	'watermark'            => '',
	'show_watermark'       => false,
	'watermark_font'       => 'sans-serif',
	'display_mode'         => 'fullpage',
	'watermark_text_alpha' => 0.1,
	'custom_font_dir'      => base_path('resources/fonts/'),
	'custom_font_data' 	   => [
			'nikosh' => [
			'R'  => 'Nikosh.ttf',    // regular font
			'B'  => 'Nikosh.ttf',       // optional: bold font
			'I'  => 'Nikosh.ttf',     // optional: italic font
			'BI' => 'Nikosh.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
        	'useKashida' => 75
		]
	],
	'auto_language_detection'  => false,
	'temp_dir'             => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
	'pdfa' 				   => false,
     'pdfaauto' 		   => false,
];