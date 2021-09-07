<?php

namespace MABEL_WOF_LITE\Code\Services {

	class Log_Service {

		public static function get_logs_from_email($email){
			$file_url = trailingslashit(WP_CONTENT_DIR) . 'wof-log.txt';
			$matches = array();
			$handle = @fopen($file_url, "r");
			if ($handle)
			{
				while (!feof($handle))
				{
					$buffer = fgets($handle);
					if(strpos($buffer, $email) !== FALSE)
						$matches[] = $buffer;
				}
				fclose($handle);
			}
			return $matches;
		}

		public static function get_log() {
			$content = file_get_contents(trailingslashit(WP_CONTENT_DIR) . 'wof-log.txt');
			return $content === false ? '' : $content;
		}

		public static function log($message) {
			$message = current_time('mysql') .' : '.$message;
			file_put_contents(trailingslashit(WP_CONTENT_DIR) .'wof-log.txt',$message . PHP_EOL, FILE_APPEND);
		}

		public static function overwrite($str){
			file_put_contents(trailingslashit(WP_CONTENT_DIR) .'wof-log.txt',$str);
		}

		public static function clear() {
			file_put_contents(trailingslashit(WP_CONTENT_DIR) .'wof-log.txt','');
		}

		public static function is_in_log($email,$wheel_id){
			global $wpdb;
			$table = $wpdb->prefix.'wof_lite_optins';

			$results = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT email FROM '.$table.' WHERE email = %s AND wheel_id = %d',
					hash('md5',$email),
					$wheel_id
				)
			);

			return count($results) > 0;
		}

		public static function add_to_db_log($email, $wheel_id){
			global $wpdb;
			$table = $wpdb->prefix.'wof_lite_optins';
			$wpdb->insert(
				$table,
				array('wheel_id' => $wheel_id, 'email' => hash('md5',$email),'created_date' => current_time('Y-m-d H:i:s',true))
			);
		}

		public static function drop_all_logs(){
			global $wpdb;
			$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix.'wof_lite_optins' );
			self::clear();
		}

	}
}