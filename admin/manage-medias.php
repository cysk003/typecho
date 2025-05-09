<?php
include 'common.php';
include 'header.php';
include 'menu.php';

$stat = \Widget\Stat::alloc();
$attachments = \Widget\Contents\Attachment\Admin::alloc();
?>
<main class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main" role="main">
            <div class="col-mb-12">

                <form method="get" class="typecho-list-operate">
                    <div class="operate">
                        <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox"
                                                                               class="typecho-table-select-all"/></label>
                        <div class="btn-group btn-drop">
                            <button class="btn dropdown-toggle btn-s" type="button"><i
                                    class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i
                                    class="i-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a lang="<?php _e('你确认要删除这些文件吗?'); ?>"
                                       href="<?php $security->index('/action/contents-attachment-edit?do=delete'); ?>"><?php _e('删除'); ?></a>
                                </li>
                            </ul>
                            <button class="btn btn-s btn-warn btn-operate"
                                    href="<?php $security->index('/action/contents-attachment-edit?do=clear'); ?>"
                                    lang="<?php _e('您确认要清理未归档的文件吗?'); ?>"><?php _e('清理未归档文件'); ?></button>
                        </div>
                    </div>
                    <div class="search" role="search">
                        <?php if ('' != $request->keywords): ?>
                            <a href="<?php $options->adminUrl('manage-medias.php'); ?>"><?php _e('&laquo; 取消筛选'); ?></a>
                        <?php endif; ?>
                        <input type="text" class="text-s" placeholder="<?php _e('请输入关键字'); ?>"
                               value="<?php echo $request->filter('html')->keywords; ?>"<?php if ('' == $request->keywords): ?> onclick="value='';name='keywords';" <?php else: ?> name="keywords"<?php endif; ?>/>
                        <button type="submit" class="btn btn-s"><?php _e('筛选'); ?></button>
                    </div>
                </form>

                <form method="post" name="manage_medias" class="operate-form">
                    <table class="typecho-list-table draggable">
                        <colgroup>
                            <col width="3%" class="kit-hidden-mb"/>
                            <col width="6%" class="kit-hidden-mb"/>
                            <col width="30%"/>
                            <col width="" class="kit-hidden-mb"/>
                            <col width="30%" class="kit-hidden-mb"/>
                            <col width="16%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="kit-hidden-mb"></th>
                            <th class="kit-hidden-mb"></th>
                            <th><?php _e('文件名'); ?></th>
                            <th class="kit-hidden-mb"><?php _e('上传者'); ?></th>
                            <th class="kit-hidden-mb"><?php _e('所属文章'); ?></th>
                            <th><?php _e('发布日期'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($attachments->have()): ?>
                            <?php while ($attachments->next()): ?>
                                <?php $mime = \Typecho\Common::mimeIconType($attachments->attachment->mime); ?>
                                <tr id="<?php $attachments->theId(); ?>">
                                    <td class="kit-hidden-mb"><input type="checkbox"
                                                                     value="<?php $attachments->cid(); ?>"
                                                                     name="cid[]"/></td>
                                    <td class="kit-hidden-mb"><a
                                            href="<?php $options->adminUrl('manage-comments.php?cid=' . $attachments->cid); ?>"
                                            class="balloon-button size-<?php echo \Typecho\Common::splitByCount($attachments->commentsNum, 1, 10, 20, 50, 100); ?>"><?php $attachments->commentsNum(); ?></a>
                                    </td>
                                    <td>
                                        <i class="mime-<?php echo $mime; ?>"></i>
                                        <a href="<?php $options->adminUrl('media.php?cid=' . $attachments->cid); ?>"><?php $attachments->title(); ?></a>
                                        <a href="<?php $attachments->permalink(); ?>"
                                           title="<?php _e('浏览 %s', $attachments->title); ?>"><i
                                                class="i-exlink"></i></a>
                                    </td>
                                    <td class="kit-hidden-mb"><?php $attachments->author(); ?></td>
                                    <td class="kit-hidden-mb">
                                        <?php if ($attachments->parentPost->cid): ?>
                                            <a href="<?php $options->adminUrl('write-' . (0 === strpos($attachments->parentPost->type, 'post') ? 'post' : 'page') . '.php?cid=' . $attachments->parentPost->cid); ?>"><?php $attachments->parentPost->title(); ?></a>
                                        <?php else: ?>
                                            <span class="description"><?php _e('未归档'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php $attachments->dateWord(); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="none"><?php _e('没有任何文件'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table><!-- end .typecho-list-table -->
                </form><!-- end .operate-form -->

                <form method="get" class="typecho-list-operate">
                    <div class="operate">
                        <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox"
                                                                               class="typecho-table-select-all"/></label>
                        <div class="btn-group btn-drop">
                            <button class="btn dropdown-toggle btn-s" type="button"><i
                                    class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?> <i
                                    class="i-caret-down"></i></button>
                            <ul class="dropdown-menu">
                                <li><a lang="<?php _e('你确认要删除这些文件吗?'); ?>"
                                       href="<?php $security->index('/action/contents-attachment-edit?do=delete'); ?>"><?php _e('删除'); ?></a>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-s btn-warn btn-operate"
                                href="<?php $security->index('/action/contents-attachment-edit?do=clear'); ?>"
                                lang="<?php _e('您确认要清理未归档的文件吗?'); ?>"><?php _e('清理未归档文件'); ?></button>
                    </div>
                    <?php if ($attachments->have()): ?>
                        <ul class="typecho-pager">
                            <?php $attachments->pageNav(); ?>
                        </ul>
                    <?php endif; ?>
                </form>

            </div>
        </div><!-- end .typecho-page-main -->
    </div>
</main>

<?php
include 'copyright.php';
include 'common-js.php';
include 'table-js.php';
include 'footer.php';
?>
