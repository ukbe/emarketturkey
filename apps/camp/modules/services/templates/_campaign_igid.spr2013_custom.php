                            <dl class="_table campaign-form">
                                <dt><?php echo emt_label_for('Campaign', __('Campaign')) ?></dt>
                                <dd class="margin-b2 t_bold t_blue t_large _noInput"><?php echo $campaign->getDisplayName() ?>
                                <?php echo input_hidden_tag('campaign', $campaign->getCode()) ?></dd>
                                </dd>
                            </dl>