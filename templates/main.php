<div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?= (!$get_id) ? 'filters__button--active' : '' ?>" href="/1247303-readme-12">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($types_content as $key => $type):?>
                    <li class="popular__filters-item filters__item">
                        <a class="filters__button filters__button--<?=$type['class_name'];?> button <?= ((int) $type['id'] === $get_id) ? 'filters__button--active' : '' ?>" href="index.php?categories-id=<?=$type['id'];?>">
                            <span class="visually-hidden"><?=$type['type']; ?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?=$type['class_name']; ?>"></use>
                            </svg>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $key => $post):?>
                
            <article class="popular__post post post-<?=htmlspecialchars($post['class_name']); ?>">
                <header class="post__header">
                    <a href="post.php?post-id=<?=($post['id']); ?>">
                        <h2><?=htmlspecialchars($post['title']); ?></h2>
                    </a>
                </header>
                <div class="post__main">
                <?php if($post['class_name'] === 'quote'):?>
                    <blockquote>
                        <p>
                            <?=htmlspecialchars($post['content']);?>
                        </p>
                    <cite><?=htmlspecialchars($post['author_quote']);?></cite>
                </blockquote>
                <?php elseif($post['class_name'] === 'text'):?>
                    <?=cutStr(htmlspecialchars($post['content']));?>
                <?php elseif($post['class_name'] === 'photo'):?>
                    <div class="post-photo__image-wrapper"> 
                        <img src="<?=htmlspecialchars($post['img_path']);?>" alt="Фото от пользователя" width="360" height="240"> 
                    </div>
                <?php elseif($post['class_name'] === 'link'):?>
                    <div class="post-link__wrapper">
                    <a class="post-link__external" href="<?=htmlspecialchars($post['site_path']);?>" title="Перейти по ссылке">
                        <div class="post-link__info-wrapper">
                            <div class="post-link__icon-wrapper">
                                <img src="https://www.google.com/s2/favicons?domain=<?= $post['site_path'] ?>" alt="Иконка">
                            </div>
                            <div class="post-link__info">
                                <h3><?=$post['title']; ?></h3>
                            </div>
                        </div>
                        <span><?=$post['content'];?></span>
                    </a>
                </div>
                <?php 
                    elseif($post['class_name'] === 'video'):?>
                    <div class="post-video__block">
                        <div class="post-video__preview">
                        <?= embed_youtube_video($post['video_path']); ?>
                            <!-- embed_youtube_video($post['video_path']) -->
                            <!-- <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188"> -->
                        </div>
                        <!-- <a href="post-details.html" class="post-video__play-big button">
                            <svg class="post-video__play-big-icon" width="14" height="14">
                                <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                            <span class="visually-hidden">Запустить проигрыватель</span>
                        </a>  -->
                    </div>
                <?php endif ?> 
                </div>
                <?php $publicationsDate = $post['publictation_date']?>
                <footer class="post__footer">
                    <div class="post__author">
                        <a class="post__author-link" href="#" title="<?=htmlspecialchars($post['first_name']. " " . $post['last_name'] ); ?>">
                            <div class="post__avatar-wrapper">
                                <img class="post__author-avatar" src="img/<?=htmlspecialchars($post['avatar_path']); ?>" alt="Аватар пользователя">
                            </div>
                            <div class="post__info">
                                <b class="post__author-name"><?=htmlspecialchars($post['first_name']. " " . $post['last_name'] ); ?></b>
                                <time class="post__time" title="<?=substr($publicationsDate, 0, -3)?>" datetime="<?=$publicationsDate?>"><?=relativeDate($publicationsDate) ?></time>
                            </div>
                        </a>
                    </div>
                    <div class="post__indicators">
                        <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                <svg class="post__indicator-icon" width="20" height="17">
                                    <use xlink:href="#icon-heart"></use>
                                </svg>
                                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                    <use xlink:href="#icon-heart-active"></use>
                                </svg>
                                <span><?=get_count_likes($connection, $post['id']); ?></span>
                                <span class="visually-hidden">Количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?=get_count_comments($connection, $post['id']); ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                        </div>
                    </div>
                </footer>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
