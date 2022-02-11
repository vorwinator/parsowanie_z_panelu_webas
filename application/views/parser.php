<?php
	echo "Przed wykonaniem skryptu dns</br>";
	$page_number=0;
	$url="/Dns/Index/page/";
	$allowed_columns=array(
		'domain',
		'ftp',
		'domain_ip',
		'domain_mx',
		'cleaner_date',
	);
	if(!isset($_GET['table_name'])){
		while(true){
			$url_with_pagination=$url.$page_number;
			$response=$this->parser_model->get_data_from_page($this->curl_functions->curl_get_html($url_with_pagination), "dns", $allowed_columns);
			if($response==0) break;
			$page_number++;
		}
	}
	$allowed_columns=http_build_query($allowed_columns);
	echo "<a href=".site_url('parser/index?url='.$url.'0&table_name=dns&'.$allowed_columns).">Synchronizuj DNS</a></br>";
	echo "Po wykonaniu skryptu dns</br>";

	echo "Przed wykonaniem skryptu ftp</br>";
	$page_number=0;
	$url="/Ftp/Index/page/";
	$allowed_columns=array(
		'name',
		'description',
		'php',
		'expires-at',
		'blocked-ftp',
		'blocked-www',
		'blocked-mail',
		'domains',
		'quota',
		'quota-percent',
		'limit',
	);
	if(!isset($_GET['table_name'])){
		while(true){
			$url_with_pagination=$url.$page_number;
			$response=$this->parser_model->get_data_from_page($this->curl_functions->curl_get_html($url_with_pagination), "ftp", $allowed_columns);
			if($response==0) break;
			$page_number++;
		}
	}
	$allowed_columns=http_build_query($allowed_columns);
	echo "<a href=".site_url('parser/index?url='.$url.'0&table_name=ftp&'.$allowed_columns).">Synchronizuj FTP</a></br>";
	echo "Po wykonaniu skryptu ftp</br>";

	echo "Przed wykonaniem skryptu domain</br>";
	$page_number=0;
	$url="/Domain/Index/page/";
	$allowed_columns=array(
			'domain',
            'ftp',
            'directory',
            'php',
            'ssl_protection',
            'dkim-active',
            'cdn',
            'blocked-www',
            'blocked-mail',
            'sub',
            'email',
            'quota',
		);
	while(true){
		$url_with_pagination=$url.$page_number;
		$response=$this->parser_model->get_data_from_page($this->curl_functions->curl_get_html($url_with_pagination), "domain", $allowed_columns);
		if($response==0) break;
		$page_number++;
	}
	$allowed_columns=http_build_query($allowed_columns);
	echo "<a href=".site_url('parser/index?url='.$url.'0&table_name=domain&'.$allowed_columns).">Synchronizuj Domeny</a></br>";
	echo "Po wykonaniu skryptu domain</br>";

	echo "<a href=".site_url('parser/index').">Synchronizuj wszystko</a></br>";
//https://webas63524.tld.pl/Domain
?>