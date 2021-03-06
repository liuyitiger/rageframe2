<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\wechat\MsgHistory;
use common\models\wechat\Rule;

$this->title = '定时群发';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= $this->title; ?></h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-xs" onclick="openEdit()">
                            <i class="fa fa-plus"></i> 创建
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>发送对象</th>
                            <th>发送类别</th>
                            <th>粉丝数量</th>
                            <th>发送时间</th>
                            <th>发送状态</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr>
                                <td><?= $model->id; ?></td>
                                <td><?= $model->tag_name ?></td>
                                <td><span class="label label-info"><?= \common\models\wechat\MassRecord::$mediaTypeExplain[$model->media_type] ?></span></td>
                                <td><?= $model->fans_num?></td>
                                <td>
                                    预计：<?= Yii::$app->formatter->asDatetime($model->send_time) ?><br>
                                    实际：<?= !empty($model->final_send_time) ? Yii::$app->formatter->asDatetime($model->final_send_time) : '暂无'  ?>
                                </td>
                                <td>
                                    <?php if($model->send_status == \common\enums\StatusEnum::ENABLED){ ?>
                                        <span class="label label-info">已发送</span>
                                    <?php }else if ($model->send_status == \common\enums\StatusEnum::DELETE){ ?>
                                    <span class="label label-danger">发送失败</span>
                                    <?php }else{ ?>
                                        <span class="label label-default">待发送</span>
                                    <?php } ?>
                                </td>
                                <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                                <td>
                                    <a href="<?= Url::to(['delete','id' => $model->id])?>" onclick="rfDelete(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination' => $pages,
                                'maxButtonCount' => 5,
                                'firstPageLabel' => "首页",
                                'lastPageLabel' => "尾页",
                                'nextPageLabel' => "下一页",
                                'prevPageLabel' => "上一页",
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/html"  id="editModel">
    <?php foreach($mediaType as $key => $item){ ?>
        <div class="col-lg-12 text-center" style="padding: 10px">
            <a href="<?= Url::to(['create', 'media_type' => $key]); ?>" class="btn btn-w-m btn-info"><?= $item; ?></a>
        </div>
    <?php } ?>
</script>

<script>
    function openEdit(){
        var html = template('editModel', []);
        //自定页
        layer.open({
            type: 1,
            title: '创建群发类型',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: false, //不显示关闭按钮
            shift: 2,
            area: ['250px', '330px'],
            shadeClose: true, //开启遮罩关闭
            content: html
        });
    }
</script>
