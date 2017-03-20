<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-title">
				<i class="fa fa-superpowers"></i>
				<h3><?php echo __('Миграции') ?></h3>
				<div class="pull-right box-toolbar">
					<?php echo HTML::anchor( Route::get('migrations_route')->uri() , __('Назад'),['class' => 'btn btn-xs btn-danger']); ?>
				</div>
			</div>
			<div class="box-body no-padding">

				<?php if (empty($messages)) { ?>
					<div class="alert alert-warning" style="border-radius: 0"><?php echo __('Миграций нет') ?></div>
				<?php } else { ?>
					<?php foreach ($messages as $message) { ?>
						<?php if (key($message) == 0) { ?>
							<?php echo $message[0] ?>
							<div class="alert alert-warning" style="border-radius: 0"><?php echo __('Миграция прошла успешно') ?></div>
						<?php } else { ?>
							<?php echo $message[key($message)] ?>
							<div class="alert alert-danger" style="border-radius: 0"><?php echo __('Ошибка') ?></div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

