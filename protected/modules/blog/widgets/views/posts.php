<div class="card blog-widget-view h-100">
	<div class="card-header">
        <?= $type?>
	</div>
	<div class="card-body">
        <div class="content-list content-image">
			<ul class="list-wrapper list-unstyled">

                <?php
                echo \yii\widgets\ListView::widget([
                    'dataProvider' => $posts,
                    
                    'summary' => false,
                    
                    'itemOptions' => [
                        'class' => 'item'
                    ],
                    'itemView' => '_view',
                    'options' => [
                        'class' => 'list-view comment-list'
                    ]
                ]);
                ?>
            </ul>

		</div>
    </div>
</div>