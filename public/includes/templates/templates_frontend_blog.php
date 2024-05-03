<html lang="de">
<head><title>CRM P+</title>
<title><?php echo $page['meta_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="Description" content="<?php echo $page['meta_description']; ?>" />
<meta name="Keywords" content="<?php echo $page['meta_keywords']; ?>" />
<?php include("includes/head.php"); ?>
<?php echo $systemdata['style_frontend']; ?>
<?php echo $page['style']; ?>
</head>
<body>
<div class="container">
	<br />
	<h1>ORDER GO - <?php echo $page['title']; ?></h1>
	<br />
	<?php echo $emsg; ?>
	<div class="row">
		<div class="col">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb px-2 py-1 mb-0">
					<li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>

					<?php if(!isset($param['category']) && !isset($param['tag'])){ ?>
					<li class="breadcrumb-item<?php if(!isset($row_blog)){echo " active";} ?>"><?php if(isset($row_blog)){ ?><a href="/blog"><?php } ?>Blog<?php if(isset($row_blog)){ ?></a><?php } ?></li>
					<?php if(isset($row_blog)){ ?><li class="breadcrumb-item<?php if(!isset($row_post)){echo " active";} ?>"><?php if(isset($row_post)){ ?><a href="/blog/<?php echo $row_blog['slug']; ?>"><?php } ?><?php echo $row_blog['title']; ?><?php if(isset($row_post)){ ?></a><?php } ?></li><?php } ?>
					<?php if(isset($row_post)){ ?><li class="breadcrumb-item active"><?php echo $row_post['title']; ?></li><?php } ?>
					<?php } ?>

					<?php if(isset($param['category'])){ ?>
						<?php if($param['category'] == ""){ ?>
					<li class="breadcrumb-item"><a href="/blog">Blog</a></li>
					<li class="breadcrumb-item active">Kategorie</li>
						<?php }else{ ?>
					<li class="breadcrumb-item"><a href="/blog">Blog</a></li>
					<li class="breadcrumb-item"><a href="/blog/kategorie">Kategorie</a></li>
					<li class="breadcrumb-item active"><?php echo $row_category['title']; ?></li>
						<?php } ?>
					<?php } ?>

					<?php if(isset($param['tag'])){ ?>
						<?php if($param['tag'] == ""){ ?>
					<li class="breadcrumb-item"><a href="/blog">Blog</a></li>
					<li class="breadcrumb-item active">Tag</li>
						<?php }else{ ?>
					<li class="breadcrumb-item"><a href="/blog">Blog</a></li>
					<li class="breadcrumb-item"><a href="/blog/tag">Tag</a></li>
					<li class="breadcrumb-item active"><?php echo $row_tag['title']; ?></li>
						<?php } ?>
					<?php } ?>

				</ol>
			</nav>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
			<div class="formular">
				<br />
				<p>Themen</p>
				<div class="shadow_fo"></div>
			</div>
			<div class="menu_container">
				<ul class="list-unstyled sitebar_list">
					<?php
						$result = mysqli_query($conn, "SELECT * FROM `blog` WHERE `blog`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' ORDER BY CAST(`blog`.`pos` AS UNSIGNED) ASC");
						while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
							if($row['slug'] == strip_tags(isset($param["blog"]) ? $param["blog"] : "")){
						?>
					<li><i class="fa fa-angle-right fa-fw"></i><a href="/blog/<?php echo $row['slug']; ?>"><u><?php echo strip_tags($row['title']); ?></u></a></li>
						<?php 
							}else{
						?>
					<li><i class="fa fa-angle-right fa-fw"></i><a href="/blog/<?php echo $row['slug']; ?>"><?php echo strip_tags($row['title']); ?></a></li>
						<?php 
							}
						}
					?>
				</ul>
			</div>
		</div>
		<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
<?php echo $html; ?>
		</div>
	</div>
</div>
<?php echo $systemdata['script_frontend']; ?>
<?php echo $page['script']; ?>
</body>
</html>