<?php
use yii\widgets\ListView;
use app\models\Feed;
?>
<div class="wrapper">
<div class="tab-content">
	<div class="activity-table card">
		<div class="card-body">
			<table class="table">
				<tbody>
                    <?php
                    echo ListView::widget([
                        'dataProvider' => Feed::getRecentFeeds(),
                        // 'layout' => "{pager}{items}\n",
                        'itemView' => '_list'
                    ]);
                    ?>
    			</tbody>
			</table>
		</div>
	</div>
</div>
</div>