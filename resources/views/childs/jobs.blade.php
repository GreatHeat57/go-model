<?php if(config('app.hide_or_show_latest_jobs_front_side') == true) : ?>
<div class="block latest-job">
    <h2>{{ t('Latest jobs') }}</h2>

    <div class="cols-3">

        @if(isset($latestJobs) && count($latestJobs) > 0)
            @foreach ($latestJobs as $key => $job)

            <div class="col">
                <div class="job">
                    <h6>
                        <?php
                            $job_categories = [];
                            if(isset($job->model_category_id) && !empty($job->model_category_id)){
                                $job_categories = explode(',',$job->model_category_id);
                            }
                        ?>
                        @if(in_array($selectedCategory->id, $job_categories))
                            {{ (isset($selectedCategory->name))? $selectedCategory->name : '' }}
                        @else
                            {{ (isset($job->model_cat[0]->name))? $job->model_cat[0]->name : '' }}
                        @endif
                    </h6>
                    <h4>{{ mb_ucfirst(str_limit($job->title, config('constant.title_limit'))) }}</h4>
                    <p>{{ (isset($job->job_cat[0]->name))? mb_ucfirst($job->job_cat[0]->name) : '' }}<br />
                        @if(isset($job->post_type->name))
                            {{ $job->post_type->name }}
                        @endif
                    </p>
                    <?php /*
                    <span class="time">
                        <?php
                            date_default_timezone_set(config('timezone.id'));
                            $start  = date_create($job->created_at);
                            $end    = date_create();
                            
                            $diff   = date_diff( $start, $end );
                            
                            echo t('Posted On');
                            echo ' ';
                            if ($diff->y) {
                                echo  $diff->y . ' ' . (($diff->y == 1) ? t('year ago'): t('years ago'));
                            }
                            else if ($diff->m) {
                                echo  $diff->m . ' ' . (($diff->m == 1) ? t('month ago'): t('months ago'));
                            }
                            else if ($diff->d) {
                                echo  $diff->d . ' ' . (($diff->d == 1) ? t('day ago'): t('days ago'));
                            }
                            else if ($diff->h) {
                                echo  $diff->h . ' ' . (($diff->h == 1) ? t('hour ago'): t('hours ago'));
                            }
                            else if ($diff->i) {
                                echo  $diff->i . ' ' . (($diff->i == 1) ? t('minute ago'): t('minutes ago'));
                            }
                            else if ($diff->s) {
                                echo  $diff->s . ' ' . (($diff->s == 1) ? t('second ago'): t('seconds ago'));
                            }
                            else {
                                echo t('never seen');
                            }   
                        ?>
                    </span>
                    <?php */ ?>
                </div>
            </div>
            @endforeach
        @endif
        <?php /*
            <!-- <div class="col">
                <div class="job">
                    <h6>Models</h6>
                    <h4>Fashion Shooting<br />Models gesucht</h4>
                    <p>Editorial<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div>

            <div class="col">
                <div class="job">
                    <h6>Kinder Models</h6>
                    <h4 class="kids">Kinder Model gesucht</h4>
                    <p>Outdoor<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div>

            <div class="col">
                <div class="job">
                    <h6>Baby Models</h6>
                    <h4 class="baby">Fashion Shooting<br />Männermodel gesucht</h4>
                    <p>Editorial<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div>

            <div class="col">
                <div class="job">
                    <h6>Kinder Models</h6>
                    <h4 class="kids">Babymodel gesucht</h4>
                    <p>Editorial<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div>

            <div class="col">
                <div class="job">
                    <h6>Models</h6>
                    <h4>Event<br />Messe Hostess gesucht</h4>
                    <p>Catalouge<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div>

            <div class="col">
                <div class="job">
                    <h6>Models</h6>
                    <h4 class="baby">TFP Shooting in Wien<br />Umgebung für Sedcard</h4>
                    <p>Editorial<br />One week, 10+ hrs/day</p>
                    <span class="time">posted 1 day ago</span>
                </div>
            </div> -->
        */ ?>
    </div>

    <div class="btn">
        <!-- Jetzt bewerben und mehr Jobs finden -->
        @if (auth()->check())
        <a href="javascript:void(0);" class="disabled_opacity disabled"> {{ t('Apply now as a model and find more jobs') }} </a>
        @else
        <a href="#" class="mfp-register-form"> {{ t('Apply now as a model and find more jobs') }} </a>
        @endif
    </div>
</div>
<?php endif; ?>