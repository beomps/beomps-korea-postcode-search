<?php
	/*
	 * Plugin Name: Beomps Korea Postcode Search 
	 * Plugin URI: Http://beomps.com
	 * Description: 한국 우편 번호 검색을 위한 플러그인입니다. 우커머스의 billing/shipping 페이지에 호환되도록 작성하였습니다. Korea Postcode Search
	 * Author: park seong beom
	 * Author URI: Http://beomps.com
	 * Version:3.3
	 */

	//woocommert checkout filed change
	add_filter( 'woocommerce_checkout_fields' , 'bkps_custom_override_checkout_fields' );

	//initiation of find button name
	$find_button_name_display = get_option('find_button_name');	
	if(get_option('find_button_name') == null || get_option('find_button_name') === " "){
		$find_button_name_display = __( '우편번호 찾기', 'beomps-korea-post-search' );
	}

	// unset is disable comlume, label is above on input field
	function bkps_custom_override_checkout_fields( $fields ) {

		  // 주석 처리된 unset 은 해당 필드를 사용하지 않을 때 사용합니다. 
	      if(!get_option('billing_email_layout'))
	      {
	      	unset($fields['billing']['billing_email']);
	      }
	      if(!get_option('billing_last_name_layout'))
	      {
	      	unset($fields['billing']['billing_last_name']);
	      }
	      if(!get_option('billing_company_layout'))
	      {
	      	unset($fields['billing']['billing_company']);
	      }
	      if(!get_option('billing_city_layout'))
	      {
	      	unset($fields['billing']['billing_city']);
	      }
          if(!get_option('billing_phone_layout'))
	      {
	        unset($fields['billing']['billing_phone']);
	      }
	      if(!get_option('shipping_last_name_layout'))
	      {
	      	unset($fields['shipping']['shipping_last_name']);
	      }
	      if(!get_option('shipping_company_layout'))
	      {
	      	unset($fields['shipping']['shipping_company']);
	      }
	      if(!get_option('shipping_city_layout'))
	      {
	      	unset($fields['shipping']['shipping_city']);
	      }	

	      global $find_button_name_display;

	      $fields['billing']['billing_address_2']['label'] = '<input type="button" id="billing_postcode_search" value="'.$find_button_name_display.'" class="btn" onclick="openDaumPostcode();" style="height: 40px;">';

	      $fields['shipping']['shipping_address_2']['label'] = '<input type="button" id="shipping_postcode_search" value="'.$find_button_name_display.'" class="btn" onclick="openDaumPostcode2();" style="height: 40px;">';
		 

	     return $fields;
	}
	 
	//add findpostcode button to woocommerce billing fields 
	add_filter( 'woocommerce_billing_fields' , 'bkps_custom_override_billing_fields' );

	function bkps_custom_override_billing_fields( $fields ) {
  
  		global $find_button_name_display;

		$fields['billing_address_2']['label'] = '<input type="button" id="billing_postcode_search" value="'.$find_button_name_display.'" class="btn" onclick="openDaumPostcode();" style="height: 40px;">';
  	 	return $fields;
	}
	 
	//add findpostcode button to woocommerce shipping fields 
	add_filter( 'woocommerce_shipping_fields' , 'bkps_custom_override_shipping_fields' );

	function bkps_custom_override_shipping_fields( $fields ) {
  
  		global $find_button_name_display;

		$fields['shipping_address_2']['label'] = '<input type="button" id="billing_postcode_search" value="'.$find_button_name_display.'" class="btn" onclick="openDaumPostcode2();" style="height: 40px;">';
  	 	return $fields;
	}



	 // add Daum postcode search 
	 // action 을 워드프레스 로딩시 로딩 되도록 작성 되어있습니다.
	 add_action('init','bkps_address_start');
	


	 // Add Daum Search Function
	 function bkps_address_start(){

	 	if(get_option('protocol_type')  === 'https')
		{
			//Daum postcode search for HTTPS
			//SSL을 사용하면 바로 아래 코드를 사용하세요.
			//wp_enqueue_script( 'postcode', 'https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js', array(), null, true );
			wp_enqueue_script( 'postcode', 'https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js', array(), null, true );
		}else{
			//Daum postcode search for HTTP
			//SSL을 사용하지 않는 다면 바로 아래 코드를 사용하세요.
			//wp_enqueue_script( 'postcode', 'http://dmaps.daum.net/map_js_init/postcode.v2.js', array(), null, true );
			wp_enqueue_script( 'postcode', 'https://ssl.daumcdn.net/dmaps/map_js_init/postcode.js', array(), null, true );
		}
		add_action('wp_enqueue_scripts', 'bkps_wp_enqueue_scripts');


		//add action for clicking button 
		function bkps_wp_enqueue_scripts() {
    	?>
		    <script type="text/javascript">
			    //for billing address
		        function openDaumPostcode() {

			        new daum.Postcode({
			            oncomplete: function(data) {
			                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.

			                <?php if(get_option('postcode_type')  === "6"){ ?>
			                	document.getElementById('billing_postcode').value = data.postcode;
			                <?php }else{ ?>
			                	document.getElementById('billing_postcode').value = data.zonecode;
			                <?php } ?>
			
			                document.getElementById('billing_address_1').value = data.address;
			
			                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			                //var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			                //document.getElementById('addr').value = addr;
			
			                document.getElementById('billing_address_2').focus();
			            }
			        }).open();
			    }
			    //for shipping address
			    function openDaumPostcode2() {

			        new daum.Postcode({
			            oncomplete: function(data) {
			                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.

			                <?php if(get_option('postcode_type')  === "6"){ ?>
			                	document.getElementById('shipping_postcode').value = data.postcode;
			                <?php }else{ ?>
			                	document.getElementById('shipping_postcode').value = data.zonecode;
			                <?php } ?>

			                document.getElementById('shipping_address_1').value = data.address;
			
			                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			                //var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			                //document.getElementById('addr').value = addr;
			
			                document.getElementById('shipping_address_2').focus();
			            }
			        }).open();
			    }
		    </script>
   		 <?php
		}
	 }
?>
<?php


/**
 * Add beomps setting menu
 */
function add_beomps_options_menu()
{
    add_menu_page(
        'BEOMPS',
        'BEOMPS',
        'manage_options',
        'beomps',
        'beomps_options_page',
        '',
        '6'
    );
}

add_action("admin_menu", "add_beomps_options_menu");

function beomps_options_page()
{
	// check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('beomps_messages', 'beomps_message', __('Settings Saved', 'beomps'), 'updated');
    }
 
    // show error/update messages
    settings_errors('beomps_messages');
    ?>
	    <div class="wrap">
	    <h1>BEOMPS Setting</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("beomps_section");
	            do_settings_sections("beomps-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
		<div class="donation">
			<h3>Donation</h3>
			<p>안녕하세요. 해당 플러그인이 유용하셨다면, 개발자에게 커피한잔의 도움은 어떨까요? 아래 페이팔 기부버튼 혹은 토스 앱을 통해 개발자에게 힘을 줄 수 있습니다. 해당 기부는 순수기부이며, 이로인한 증빙서류는 발급이 불가합니다. 또한, 기부와 별개로 해당 소스의 사용 및 복제 그리고 상업 목적 재사용 모두 무료 입니다. 감사합니다.</p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHPwYJKoZIhvcNAQcEoIIHMDCCBywCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYCKIUZn3GVEAFCmHxtZlQtdgW0n93yeiXc51Gw0k3ZzwrncMgb7xfO9XPRUM5K6A+plaPL5upP104U+RZejbhC6joofpRDtouohU62AkrmuG8S2G2AxLFCN2sqDsSzLG0febgeP1nBYGfTzV5Krqpvg1reBm7mSEvRDiaIVPo3MxzELMAkGBSsOAwIaBQAwgbwGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQI6hwkmM3xqOSAgZg5U78N2lBSbXBg2ICRWDTnABM59zK4+nuD5RvegXR7gmIIFmVG2FFSMWtsgL3vAPMDuHyn3Kg8UdPH2c2816MMEkG6lFCSHCoFqgURWe4+3bN0YHTFfd8QABwoAQbBwrAFPuP2BKr/O6nTl9MaSlZUfBuPbNuiAH8SIjYOlAjtuTTrtczDB6PDzlhR22L5ChKzdMi3eKuYTKCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTE3MDMyMjA2MzA1NlowIwYJKoZIhvcNAQkEMRYEFJkwN6X47UvHiQFY5PqJHcEZtgFVMA0GCSqGSIb3DQEBAQUABIGAUQI4oY+zaDpUTnOmxVjOXTjYLzmHKJnlW66iyYjkBn1syD0+FwZTVAqQYQT8zJPHLnsKUX6HPZt+Pwi5XJNd22eY1JAwp9574+hNtfb3L7737NdE4dtOnq6OtJVQfrlStGQJej6wWYaY+GttnX37oOZR3fm497NH7v/o6UJVatg=-----END PKCS7-----
">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<a href="http://get.toss.im/RErc/l8fNDOmqIB"><img alt="" border="0" src="https://www.beomps.com/wp-content/uploads/2017/03/20170322_154726.png" width="200" height="200"></a>
		</div>
	<?php
}

function display_find_button_element()
{
	?>
    	<input type="text" name="find_button_name" id="find_button_name" value="<?php echo get_option('find_button_name'); ?>" />
    <?php
}
		
function display_billing_email_layout_element()
{
	?>
		<input type="checkbox" name="billing_email_layout" value="1" <?php checked(1, get_option('billing_email_layout'), true); ?> /> 
	<?php
}

function display_billing_last_name_layout_element()
{
	?>
		<input type="checkbox" name="billing_last_name_layout" value="1" <?php checked(1, get_option('billing_last_name_layout'), true); ?> /> 
	<?php
}

function display_billing_company_layout_element()
{
	?>
		<input type="checkbox" name="billing_company_layout" value="1" <?php checked(1, get_option('billing_company_layout'), true); ?> /> 
	<?php
}

function display_billing_city_layout_element()
{
	?>
		<input type="checkbox" name="billing_city_layout" value="1" <?php checked(1, get_option('billing_city_layout'), true); ?> /> 
	<?php
}

function display_billing_phone_layout_element()
{
	?>
		<input type="checkbox" name="billing_phone_layout" value="1" <?php checked(1, get_option('billing_phone_layout'), true); ?> /> 
	<?php
}

function display_shipping_last_name_layout_element()
{
	?>
		<input type="checkbox" name="shipping_last_name_layout" value="1" <?php checked(1, get_option('shipping_last_name_layout'), true); ?> /> 
	<?php
}

function display_shipping_company_layout_element()
{
	?>
		<input type="checkbox" name="shipping_company_layout" value="1" <?php checked(1, get_option('shipping_company_layout'), true); ?> /> 
	<?php
}

function display_shipping_city_layout_element()
{
	?>
		<input type="checkbox" name="shipping_city_layout" value="1" <?php checked(1, get_option('shipping_city_layout'), true); ?> /> 
	<?php
}

function display_protocol_element()
{
	?>
    	<select name="protocol_type">
		  <option value="http" <?php selected( get_option('protocol_type'), http ); ?>>http</option>
		  <option value="https" <?php selected( get_option('protocol_type'), https ); ?>>https</option>
		</select>
    <?php
}

function display_postcode_element()
{
	?>
    	<select name="postcode_type">
		  <option value="5" <?php selected( get_option('postcode_type'), 5 ); ?>>신주소(5자리)</option>
		  <option value="6" <?php selected( get_option('postcode_type'), 6 ); ?>>구주소(6자리)</option>
		</select>
    <?php
}

function display_beomps_options_fields()
{
	add_settings_section("beomps_section", "All Settings", null, "beomps-options");
	
	add_settings_field("protocol_type", __( '프로토콜 타입', 'beomps-korea-post-search' ), "display_protocol_element", "beomps-options", "beomps_section");

	add_settings_field("postcode_type", __( '우편주소 타입', 'beomps-korea-post-search' ), "display_postcode_element", "beomps-options", "beomps_section");

	add_settings_field("find_button_name", __( '우편번호 찾기 버튼명<br>(아무값도 입력하지 않을시, <i>우편번호 찾기</i> 로 입력됩니다) ', 'beomps-korea-post-search' ), "display_find_button_element", "beomps-options", "beomps_section");

    add_settings_field("billing_email_layout", __( '빌링(청구) 이메일 표시', 'beomps-korea-post-search' ), "display_billing_email_layout_element", "beomps-options", "beomps_section");

    add_settings_field("billing_last_name_layout", __( '빌링(청구) 성 표시', 'beomps-korea-post-search' ), "display_billing_last_name_layout_element", "beomps-options", "beomps_section");

    add_settings_field("billing_company_layout", __( '빌링(청구) 회사명 표시', 'beomps-korea-post-search' ), "display_billing_company_layout_element", "beomps-options", "beomps_section");

    add_settings_field("billing_city_layout", __( '빌링(청구) 도시명 표시', 'beomps-korea-post-search' ), "display_billing_city_layout_element", "beomps-options", "beomps_section");

    add_settings_field("billing_phone_layout", __( '빌링(청구) 휴대폰 표시', 'beomps-korea-post-search' ), "display_billing_phone_layout_element", "beomps-options", "beomps_section");

    add_settings_field("shipping_last_name_layout", __( '쉬핑(배송) 성 표시', 'beomps-korea-post-search' ), "display_shipping_last_name_layout_element", "beomps-options", "beomps_section");

    add_settings_field("shipping_company_layout", __( '쉬핑(배송) 회사명 표시', 'beomps-korea-post-search' ), "display_shipping_company_layout_element", "beomps-options", "beomps_section");

    add_settings_field("shipping_city_layout", __( '쉬핑(배송) 도시명 표시', 'beomps-korea-post-search' ), "display_shipping_city_layout_element", "beomps-options", "beomps_section");

    // register all setting
    register_setting("beomps_section", "protocol_type");
    register_setting("beomps_section", "postcode_type");
    register_setting("beomps_section", "find_button_name");
    register_setting("beomps_section", "billing_email_layout");
    register_setting("beomps_section", "billing_last_name_layout");
    register_setting("beomps_section", "billing_company_layout");
    register_setting("beomps_section", "billing_city_layout");
    register_setting("beomps_section", "billing_phone_layout");
    register_setting("beomps_section", "shipping_last_name_layout");
    register_setting("beomps_section", "shipping_company_layout");
    register_setting("beomps_section", "shipping_city_layout");

}

add_action("admin_init", "display_beomps_options_fields");

?>
