<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	
	class Sendmail {
		
		protected $CI;
	
		function __construct() { 
			
			$this->CI =& get_instance();
			
			require APPPATH.'third_party/phpmailer/src/Exception.php';
			require APPPATH.'third_party/phpmailer/src/PHPMailer.php';
			require APPPATH.'third_party/phpmailer/src/SMTP.php';
		}
		
		function main() {
			// $this->cek_akuntansi();
			// $this->cek_perpajakan();
			// $this->cek_lainnya();
			
			$this->CI->load->model('Klien_model');
			$this->CI->load->model('M_Permintaan_akuntansi');
			$this->CI->load->model('M_Permintaan_perpajakan');
			$this->CI->load->model('M_Permintaan_lainnya');
			
			$klien = $this->CI->Klien_model->getAllKlien();
			foreach ($klien as $k) {
				$akuntansi	= $this->CI->M_Permintaan_akuntansi->getUnsend($k['id_klien']);
				$perpajakan	= $this->CI->M_Permintaan_perpajakan->getUnsend($k['id_klien']);
				$lainnya	= $this->CI->M_Permintaan_lainnya->getUnsend($k['id_klien']);
				
				if( $akuntansi ) {
					foreach ($akuntansi as $id => $a) {
						$tanggal			= explode(' ', $a['tanggal_permintaan']);
						$tanggal_permintaan	= date_create( $tanggal[0] );
						$tanggal_sekarang	= date_create(date("d-m-Y"));
						$diff				= date_diff($tanggal_permintaan,$tanggal_sekarang);
						if ($diff->format("%a") < 7) {
							unset( $id );
						} else {
						}
					}
				}
				if( $perpajakan ) {
					foreach ($perpajakan as $id => $p) {
						$tanggal			= explode(' ', $p['tanggal_permintaan']);
						$tanggal_permintaan	= date_create( $tanggal[0] );
						$tanggal_sekarang	= date_create(date("d-m-Y"));
						$diff				= date_diff($tanggal_permintaan,$tanggal_sekarang);
						if ($diff->format("%a") < 7) {
							unset( $id );
						} else {
						}
					}
				}
				if( $lainnya ) {
					foreach ($lainnya as $id => $l) {
						$tanggal			= explode(' ', $l['tanggal_permintaan']);
						$tanggal_permintaan	= date_create( $tanggal[0] );
						$tanggal_sekarang	= date_create(date("d-m-Y"));
						$diff				= date_diff($tanggal_permintaan,$tanggal_sekarang);
						if ($diff->format("%a") < 7) {
							unset( $id );
						} else {
						}
					}
				}
				
				if ($akuntansi || $perpajakan || $lainnya) {
					$this->sendMail($k);
					$this->CI->M_Permintaan_akuntansi->emailSent($a['id_data']);
					$this->CI->M_Permintaan_perpajakan->emailSent($a['id_data']);
					$this->CI->M_Permintaan_lainnya->emailSent($a['id_data']);
				}
			}
			
		}
		
		function sendMail($klien) {
			$mail = new PHPMailer(true);
			try {
				//Server settings
				//$mail->SMTPDebug  = SMTP::DEBUG_SERVER; // Enable verbose debug output
				$mail->isSMTP(); // Send using SMTP
				$mail->Host       = 'data.hrwconsulting.id'; // Set the SMTP server to send through
				$mail->SMTPAuth   = true; // Enable SMTP authentication
				$mail->Username   = Globals::emailSender(); // SMTP username
				$mail->Password   = Globals::passSender(); // SMTP password
				//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
				//$mail->Port       = 587; // TCP port to connect to
				$mail->Port       = 465;
			
				//Sender & reply to
				$mail->setFrom(Globals::emailSender(), 'Data HRWConsulting'); // Name is optional
				$mail->addReplyTo(Globals::emailSender(), 'Data HRWConsulting');
				
				//Recipients
				$mail->addAddress($klien['email_klien']); // Add a recipient
				$mail->addCC($klien['email_pimpinan']);
				$mail->addCC($klien['email_counterpart']);
				//$mail->addBCC('bcc@example.com');
			
				// Attachments
				//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
			
				// Content
				$mail->isHTML(true); // Set email format to HTML
				$mail->Subject = 'Permintaan Data Bulanan';
				$mail->Body    = 
					'Kepada<br>
					'.$klien['nama_klien'].'<br>
					Di Tempat<br><br>
					
					Anda memiliki beberapa Permintaan Data Bulanan yang belum dipenuhi. Harap segera melengkapi permintaan data dengan mengirimkannya melalui website <b>Request Data Hirwan dan Rekan</b> yang dapat diakses <a href="data.hrwconsulting.id"><b>disini.</b></a>
					<br><br>
					
					Best Regards,<br>
					<b>Hirwan Tjahjadi & Rekan</b><br>
					Jl. Krekot Bunder IV No. 47B, Jakarta Pusat<br>
					P +62-21 3511027<br>';
				
				$mail->AltBody = '
					Anda memiliki beberapa Permintaan Data Bulanan yang belum dipenuhi. Harap segera melengkapi permintaan data dengan mengirimkannya melalui website Request Data Hirwan dan Rekan berikut.
					
					https://data.hrwconsulting.id/
					
					Best Regards 
					Hirwan Tjahjadi & Rekan';
			
				$mail->send();
				return true;
			} catch (Exception $e) {
				return false;
				// echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
			}
		}

		public function resetPassword($user, $link) {
			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP(); // Send using SMTP
				$mail->Host			= 'data.hrwconsulting.id'; // Set the SMTP server to send through
				$mail->SMTPAuth		= true; // Enable SMTP authentication
				$mail->Username		= Globals::emailSender(); // SMTP username
				$mail->Password		= Globals::passSender(); // SMTP password
				$mail->SMTPSecure	= PHPMailer::ENCRYPTION_SMTPS;
				$mail->Port			= 465;
				
				//Sender & reply to
				$mail->setFrom(Globals::emailSender(), 'Data HRWConsulting');
				$mail->addReplyTo(Globals::emailSender(), 'Data HRWConsulting');
				
				//Recipients
				$mail->addAddress($user['email_user']); // Add a recipient
				
				// Content
				$mail->isHTML(true); // Set email format to HTML
				$mail->Subject	= 'Reset Password';
				$mail->Body		= 
					'Seseorang telah melakukan permintaan Reset Password pada akun '.$user['nama'].'. Jika itu bukan Anda, silahkan abaikan pesan ini. Jika benar Anda, silahkan ikuti tautan dibawah ini untuk memperbarui kata sandi Anda.<br><br> 
					'.$link.'<br><br> 
					Best Regards,<br>
					<b>Hirwan Tjahjadi & Rekan</b><br>
					Jl. Krekot Bunder IV No. 47B, Jakarta Pusat<br>
					P +62-21 3511027<br>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				$mail->send();
				return true;
			} catch (Exception $e) {
				return false;
				// return "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
			}
		}
		
		// function cek_akuntansi() {
		// 	$this->CI->load->model('M_Permintaan_akuntansi');
		// 	$this->CI->load->model('M_Pengiriman_akuntansi');
			
		// 	$permintaan_akuntansi   = $this->CI->M_Permintaan_akuntansi->getAllPermintaan();
		// 	$pengiriman_akuntansi   = $this->CI->M_Pengiriman_akuntansi->getAllPengiriman();
			
		// 	foreach($pengiriman_akuntansi as $b) {
		// 		foreach($permintaan_akuntansi as $a => $val) {
		// 			if($val['id_permintaan'] == $b['id_permintaan'])
		// 			unset($permintaan_akuntansi[$a]);
		// 		}
		// 	}
			
		// 	foreach($permintaan_akuntansi as $a) {
		// 		if($a['notifikasi'] == null) {
		// 			$nama_klien = $a['nama_klien'];
		// 			$email_perusahaan = $a['email'];
		// 			$email_pimpinan = $a['email_pimpinan'];
		// 			$email_counterpart = $a['email_counterpart'];
					
		// 			$tanggal_permintaan = date_create($a['tanggal_permintaan']);
		// 			$tanggal_sekarang = date_create(date("d-m-Y H:i"));
		// 			$diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
		// 			$selisih = $diff->format("%a");
					
		// 			if($selisih >= 7) {
		// 				$this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
						
		// 				$id_permintaan = $a['id_permintaan'];
		// 				$q = "UPDATE permintaan_akuntansi SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
		// 				$this->CI->db->query($q);
		// 			}
		// 		} 
		// 	}
		// }
		
		// function cek_perpajakan() {
		// 	$this->CI->load->model('M_Permintaan_perpajakan');
		// 	$this->CI->load->model('M_Pengiriman_perpajakan');
			
		// 	$permintaan_perpajakan   = $this->CI->M_Permintaan_perpajakan->getAllPermintaan();
		// 	$pengiriman_perpajakan   = $this->CI->M_Pengiriman_perpajakan->getAllPengiriman();
			
		// 	foreach($pengiriman_perpajakan as $b) {
		// 		foreach($permintaan_perpajakan as $a => $val) {
		// 			if($val['id_permintaan'] == $b['id_permintaan'])
		// 			unset($permintaan_perpajakan[$a]);
		// 		}
		// 	}
			
		// 	foreach($permintaan_perpajakan as $a) {
		// 		if($a['notifikasi'] == null) {
		// 			$nama_klien = $a['nama_klien'];
		// 			$email_perusahaan = $a['email'];
		// 			$email_pimpinan = $a['email_pimpinan'];
		// 			$email_counterpart = $a['email_counterpart'];
					
		// 			$tanggal_permintaan = date_create($a['tanggal_permintaan']);
		// 			$tanggal_sekarang = date_create(date("d-m-Y H:i"));
		// 			$diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
		// 			$selisih = $diff->format("%a");
					
		// 			if($selisih >= 7) {
		// 				$this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
						
		// 				$id_permintaan = $a['id_permintaan'];
		// 				$q = "UPDATE permintaan_perpajakan SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
		// 				$this->CI->db->query($q);
		// 			}
		// 		} 
		// 	}
		// }
		
		// function cek_lainnya() {
		// 	$this->CI->load->model('M_Permintaan_lainnya');
		// 	$this->CI->load->model('M_Pengiriman_lainnya');
			
		// 	$permintaan_lainnya   = $this->CI->M_Permintaan_lainnya->getAllPermintaan();
		// 	$pengiriman_lainnya   = $this->CI->M_Pengiriman_lainnya->getAllPengiriman();
			
		// 	foreach($pengiriman_lainnya as $b) {
		// 		foreach($permintaan_lainnya as $a => $val) {
		// 			if($val['id_permintaan'] == $b['id_permintaan'])
		// 			unset($permintaan_lainnya[$a]);
		// 		}
		// 	}
		
		// 	foreach($permintaan_lainnya as $a) {
		// 		if($a['notifikasi'] == null) {
		// 			$nama_klien = $a['nama_klien'];
		// 			$email_perusahaan = $a['email'];
		// 			$email_pimpinan = $a['email_pimpinan'];
		// 			$email_counterpart = $a['email_counterpart'];
					
		// 			$tanggal_permintaan = date_create($a['tanggal_permintaan']);
		// 			$tanggal_sekarang = date_create(date("d-m-Y H:i"));
		// 			$diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
		// 			$selisih = $diff->format("%a");
					
		// 			if($selisih >= 7) {
		// 				$this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
						
		// 				$id_permintaan = $a['id_permintaan'];
		// 				$q = "UPDATE permintaan_lainnya SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
		// 				$this->CI->db->query($q);
		// 			}
		// 		} 
		// 	}
		// }
	}
?>