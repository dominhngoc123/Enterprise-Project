<?php

use common\models\constant\StatusConstant;
use frontend\models\Campaign;
use frontend\models\Category;
use frontend\models\Department;
use frontend\models\Idea;
use kartik\tabs\TabsX;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<!-- <div class="widget">
   <h5 class="widget-title"><span>Search</span></h5>
   <form action="<?= Url::to(['idea/search']) ?>" method="GET" class="widget-search">
      <input id="search-query" name="inputSearch" type="search" placeholder="Type &amp; Hit Enter...">
      <button type="submit"><i class="ti-search"></i></button>
   </form>
</div> -->
<!-- categories -->
<div class="widget">
   <h5 class="widget-title"><span>Categories</span></h5>
   <ul class="list-unstyled widget-list">
      <?php $categories = Category::find()->where(['=', 'status', StatusConstant::ACTIVE])->all(); ?>
      <?php if ($categories) : ?>
         <?php foreach ($categories as $category) : ?>
            <li><a href="<?= Url::to(['idea/get-ideas-by-category', 'categoryId' => $category->id]); ?>" class="d-flex"><?= "$category->name " ?>
                  <small class="ml-auto">(<?= Idea::find()->where(['=', 'categoryId', $category->id])->count(); ?>)</small></a>
            </li>
         <?php endforeach; ?>
      <?php else : ?>
         <li><a href="" class="d-flex" style="pointer-events: none !important;">No category found</a></li>
      <?php endif; ?>
   </ul>
</div>
<!-- departments -->
<div class="widget">
   <h5 class="widget-title"><span>Department</span></h5>
   <ul class="list-unstyled widget-list">
      <?php $departments = Department::find()->where(['=', 'status', StatusConstant::ACTIVE])->all(); ?>
      <?php if ($departments) : ?>
         <?php foreach ($departments as $department) : ?>
            <li><a href="<?= Url::to(['idea/get-ideas-by-department', 'departmentId' => $department->id]); ?>" class="d-flex"><?= $department->name ?>
                  <small class="ml-auto">(<?= Idea::find()->where(['=', 'departmentId', $department->id])->count(); ?>)</small></a>
            </li>
         <?php endforeach; ?>
      <?php else : ?>
         <li><a href="" class="d-flex" style="pointer-events: none !important;">No department found</a></li>
      <?php endif; ?>
   </ul>
</div>
<div class="widget">
   <h5 class="widget-title"><span>Campaign</span></h5>
   <ul class="list-unstyled widget-list">
      <?php $campaigns = Campaign::find()->where(['=', 'status', StatusConstant::ACTIVE])->all(); ?>
      <?php if ($campaigns) : ?>
         <?php foreach ($campaigns as $campaign) : ?>
            <li><a href="<?= Url::to(['idea/get-ideas-by-campaign', 'campaignId' => $campaign->id]); ?>" class="d-flex"><?= $campaign->name ?>
                  <small class="ml-auto">(<?= Idea::find()->where(['=', 'campaignId', $campaign->id])->count(); ?>)</small></a>
            </li>
         <?php endforeach; ?>
      <?php else : ?>
         <li><a href="" class="d-flex" style="pointer-events: none !important;">No department found</a></li>
      <?php endif; ?>
   </ul>
</div>
<?php
$most_popular = Idea::find()->select(['*', '`upvote_count` - `downvote_count` as like_rate'])->where(['=', 'status', StatusConstant::ACTIVE])->andWhere(['parentId' => NUll])->orderBy(['like_rate' => SORT_DESC])->limit(5)->all();
$most_viewed = Idea::find()->where(['=', 'status', StatusConstant::ACTIVE])->andWhere(['parentId' => NUll])->orderBy(['view_count' => SORT_DESC])->limit(5)->all();
$lastest_ideas = Idea::find()->where(['=', 'status', StatusConstant::ACTIVE])->andWhere(['parentId' => NUll])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
$lastest_comments = Idea::find()->where(['=', 'status', StatusConstant::ACTIVE])->andWhere(['NOT', ['parentId' => NUll]])->orderBy(['created_at' => SORT_DESC])->limit(5)->all();
$content_most_popular = '<div class="widget"><h5 class="widget-title"><span>Most popular</span></h5>';
if ($most_popular) {
   foreach ($most_popular as $idea) {
      $time = strtotime($idea->created_at);
      $date = date('Y-m-d', $time);
      $url = Url::to(['idea/view', 'id' => $idea->id]);
      $content_most_popular .= '<ul class="list-unstyled widget-list">';
      $content_most_popular .= '<li class="media widget-post align-items-center">';
      $content_most_popular .= '<a href="' . $url . '"><img loading="lazy" class="mr-3" src="../images/post/post-6.jpg"></a>';
      $content_most_popular .= '<div class="media-body"><h5 class="h6 mb-0"><a href="' . $url . '">' . $idea->title . '</a></h5><small>' . $date . '</small></div>';
      $content_most_popular .= '</li>';
      $content_most_popular .= '</ul>';
   }
} else {
   $content_most_popular .= '<ul class="list-unstyled widget-list"><li class="media widget-post align-items-center"><div class="media-body"><h5 class="h6 mb-0"><a style="pointer-events: none !important;">No lastest idea found</a></h5></div></li></ul>';
}
$content_most_popular .= '</div>';
$content_most_viewed = '<div class="widget"><h5 class="widget-title"><span>Most viewed</span></h5>';
if ($most_viewed) {
   foreach ($most_viewed as $idea) {
      $time = strtotime($idea->created_at);
      $date = date('Y-m-d', $time);
      $url = Url::to(['idea/view', 'id' => $idea->id]);
      $content_most_viewed .= '<ul class="list-unstyled widget-list">';
      $content_most_viewed .= '<li class="media widget-post align-items-center">';
      $content_most_viewed .= '<a href="' . $url . '"><img loading="lazy" class="mr-3" src="../images/post/post-6.jpg"></a>';
      $content_most_viewed .= '<div class="media-body"><h5 class="h6 mb-0"><a href="' . $url . '">' . $idea->title . '</a></h5><small>' . $date . '</small></div>';
      $content_most_viewed .= '</li>';
      $content_most_viewed .= '</ul>';
   }
} else {
   $content_most_viewed .= '<ul class="list-unstyled widget-list"><li class="media widget-post align-items-center"><div class="media-body"><h5 class="h6 mb-0"><a style="pointer-events: none !important;">No lastest idea found</a></h5></div></li></ul>';
}
$content_most_viewed .= '</div>';
$content_lastest_ideas = '<div class="widget"><h5 class="widget-title"><span>Lastest ideas</span></h5>';
if ($lastest_ideas) {
   foreach ($lastest_ideas as $idea) {
      $time = strtotime($idea->created_at);
      $date = date('Y-m-d', $time);
      $url = Url::to(['idea/view', 'id' => $idea->id]);
      $content_lastest_ideas .= '<ul class="list-unstyled widget-list">';
      $content_lastest_ideas .= '<li class="media widget-post align-items-center">';
      $content_lastest_ideas .= '<a href="' . $url . '"><img loading="lazy" class="mr-3" src="../images/post/post-6.jpg"></a>';
      $content_lastest_ideas .= '<div class="media-body"><h5 class="h6 mb-0"><a href="' . $url . '">' . $idea->title . '</a></h5><small>' . $date . '</small></div>';
      $content_lastest_ideas .= '</li>';
      $content_lastest_ideas .= '</ul>';
   }
} else {
   $content_lastest_ideas .= '<ul class="list-unstyled widget-list"><li class="media widget-post align-items-center"><div class="media-body"><h5 class="h6 mb-0"><a style="pointer-events: none !important;">No lastest idea found</a></h5></div></li></ul>';
}
$content_lastest_ideas .= '</div>';
$content_lastest_comment = '<div class="widget"><h5 class="widget-title"><span>Lastest comments</span></h5>';
if ($lastest_comments) {
   foreach ($lastest_comments as $comment) {
      $time = strtotime($comment->created_at);
      $date = date('Y-m-d', $time);
      $url = Url::to(['idea/view', 'id' => $comment->parentId]);
      $content_lastest_comment .= '<ul class="list-unstyled widget-list">';
      $content_lastest_comment .= '<li class="media widget-post align-items-center">';
      $content_lastest_comment .= '<a href="' . $url . '"><img loading="lazy" class="mr-3" src="../images/post/post-6.jpg"></a>';
      $content_lastest_comment .= '<div class="media-body"><h5 class="h6 mb-0"><a href="' . $url . '">' . $comment->content . '</a></h5><small>' . $date . '</small></div>';
      $content_lastest_comment .= '</li>';
      $content_lastest_comment .= '</ul>';
   }
} else {
   $content_lastest_comment .= '<ul class="list-unstyled widget-list"><li class="media widget-post align-items-center"><div class="media-body"><h5 class="h6 mb-0"><a style="pointer-events: none !important;">No lastest comment found</a></h5></div></li></ul>';
}
$content_lastest_comment .= '</div>';
$items = [
   [
      'label' => 'Trending',
      'items' => [
         [
            'label' => '<i class="fas fa-thumbs-up"></i>&nbsp;Most popular',
            'encode' => false,
            'content' => $content_most_popular,
            'active' => true,
         ],
         [
            'label' => '<i class="far fa-arrow-alt-circle-up"></i>&nbsp;Most viewed',
            'encode' => false,
            'content' => $content_most_viewed,
         ],
      ],
   ],
   [
      'label' => 'Lastest',
      'items' => [
         [
            'label' => '<i class="fas fa-lightbulb"></i>&nbsp;&nbsp;&nbsp;Idea',
            'encode' => false,
            'content' => $content_lastest_ideas,
         ],
         [
            'label' => '<i class="fas fa-comment"></i>&nbsp;Comment',
            'encode' => false,
            'content' => $content_lastest_comment,
         ],
      ],
   ],
];
echo TabsX::widget([
   'items' => $items,
   'position' => TabsX::POS_ABOVE,
   'encodeLabels' => false
]);
?>
<script>
   $(document).ready(function() {
      console.log("OK");
      $('#w1-dd0-tab0').addClass('active');
      $('#w1-dd0-tab0').addClass('show');
      $('#w1-dd0-tab0').show();
      $('.dropdown-item').on('click', function() {
         let tab_pane_id = $(this).attr('href');
         console.log(tab_pane_id);
         $('.tab-pane').removeClass('active');
         $('.tab-pane').removeClass('show');
         $('.tab-pane').hide();
         $(tab_pane_id).addClass('active');
         $(tab_pane_id).addClass('show');
         $(tab_pane_id).show();
      });

   })
</script>