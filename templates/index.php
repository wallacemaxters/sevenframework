<?php $this->extend('templates/pai') ?>

<?php $this->startSection('content') ?>
	<h1>Meu nome é <?= $nome ?></h1>


	<form method="post" enctype="multipart/form-data">
		
		<input type="file" name="file[a][b][]"  multiple />
		<input type="submit" />
	</form>

<?php $this->endSection() ?>
