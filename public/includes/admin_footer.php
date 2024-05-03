<footer class="bg-<?php echo $_SESSION["admin"]["bgcolor_header_footer"]; ?> border-top border-<?php echo $_SESSION["admin"]["border_header_footer"]; ?> fixed-bottom">
	<div class="<?php echo $_SESSION["admin"]["full_width"] == 1 ? "container-fluid" : "container"; ?>">
		<div class="row">
			<div class="col-md-12 col-xs-12 text-right">
				<p class="copyright text-<?php echo $_SESSION["admin"]["color_text"]; ?> m-0">Copyright &copy; <?php echo date("Y"); ?> <span><a href="/index" class="text-<?php echo $_SESSION["admin"]["color_link"]; ?>">Verwaltungssystem</a></span> All Right Of Reserved</p>
			</div>
		</div>
	</div>
</footer>