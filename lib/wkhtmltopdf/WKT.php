<?php

/**
 * Custom Wrapper class to access WTKHTMLTOPDF (http://code.google.com/p/wkhtmltopdf/)
 *
 *	@author Team Webnaplo
 *	@date 10/11/2011
 **/
class WTK {
	private static $BIN_PATH = "/bin/wkhtmltopdf.exe";

	/**
	 * Create a PDF from the URL and return the filename or download it directly
	 **/
	public static function exportPDF($url, $path = null, $download=false) {
		$url = escapeshellarg($url);

		if($path == null) $path = option('reports_dir');
		
		$timestamp = time();
		$fileName = "export_pdf_$timestamp";
		
		
		$cmd = (dirname(file_path(__FILE__))) . WTK::$BIN_PATH; 

		$blah = shell_exec("$cmd $url $path/$fileName.pdf");
		// print_r($blah);
		if($download) {
			$str = file_get_contents("$path/$fileName.pdf");

			header('Content-Type: application/pdf');
			header('Content-Length: '.strlen($str));
			header('Content-Disposition: inline; filename="pdf.pdf"');
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			ini_set('zlib.output_compression','0');
			die($str);
		} else {
			return $path . DIRECTORY_SEPARATOR . $fileName . ".pdf";
		}
	}
}