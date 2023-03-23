<?php

function func_private_template_short_code( $atts ) {
	if(!is_admin()) {
		if(isset($_GET['band_id'])) {
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pc_user_meta WHERE meta_key = 'band-id' AND meta_value='".$_GET['band_id']."' " );

		if ( $results ) {
		    // Data found, display it here
		    foreach ( $results as $result ) {
		    	$user_id = $result->user_id;
		    	$result_array = array();
				$results_inner = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pc_user_meta WHERE user_id='".$user_id."' " );
	    		foreach ( $results_inner as $result_inner ) {
		    		$result_array[$result_inner->meta_key] = $result_inner->meta_value;
	    		}

	    		$return = '';
	    		if(isset($atts['page_redirect'])) {
		    		$return .= '<meta http-equiv="refresh" content="900; url='.$atts['page_redirect'].'">';
		    	}
				$return .= '<table class="has-fixed-layout">
				          <tbody>
				            <tr>
				              <td>Band ID Number</td>
				              <td>'; if(isset($result_array['band-id'])){ $return .= $result_array['band-id']; } $return .= '</td>
				            </tr>
				            <tr>
				              <td>First Contact Phone</td>
				              <td>'; if(isset($result_array['telephone-number'])) { $return .= '<a href="tel:'.$result_array['telephone-number'].'">Call</a>'; } $return .= '</td>
				            </tr>
				            <tr>
				              <td>Second Contact</td>
				              <td>'; if(isset($result_array['telephone-number-two'])) { $return .= '<a href="tel:'.$result_array['telephone-number-two'].'">Call</a>'; } $return .= '</td>
				            </tr>
				            <tr>
				              <td>Medical Information</td>
				              <td>'; if(isset($result_array['medical-information'])) { $return .= $result_array['medical-information']; } $return .= '</td>
				            </tr>
				            <tr>
				              <td>Secret Code Word</td>
				              <td>'; if(isset($result_array['secret-code-word'])) { $return .= $result_array['secret-code-word']; } $return .= '</td>
				            </tr>';
				$return .= '</tbody>
				    </table>';
		    }
		} else {
		    $return = '<h2>No results found</h2>';
			$return .= '<h2>Lost Person</h2>
			<form method="get" action="'.get_site_url().'/'.$atts['result_page_slug'].'/">
				<label>Band ID:</label><input type="text" name="band_id" placeholder="Band ID"><br>
				<input type="submit" value="submit">
			</form>';
		}
	} else {
		$return .= '<h2>Lost Person</h2>
		<form method="get" action="'.get_site_url().'/'.$atts['result_page_slug'].'/">
			<label>Band ID:</label><input type="text" name="band_id" placeholder="Band ID"><br>
			<input type="submit" value="submit">
		</form>';
	}
	} else {
		$return = '[private_template_short_code]';
	}
	return $return;
}
add_shortcode( 'private_template_short_code', 'func_private_template_short_code' );


function func_lost_person( $atts ) {
	if(!is_admin()) {
		$return = '<h2>Lost Person</h2>
		<form method="get" action="'.get_site_url().'/'.$atts['result_page_slug'].'/">
			<label>Band ID:</label><input type="text" name="band_id" placeholder="Band ID"><br>
			<input type="submit" value="submit">
		</form>';
	} else {
		$return = '[private_template_short_code]';
	}
	return $return;
}
add_shortcode( 'lost_person', 'func_lost_person' );

?>
