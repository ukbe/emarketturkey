        <dl id="subNav">
            <dt><a href=""><?php echo __('TX') ?></a></dt>
            <dd class="ui-corner-tl<?php echo checkActivePage('@homepage', null, false, '_selected') ?>"><?php echo link_to(__('Overview'), '@homepage') ?></dd>
            <dd class="ui-corner-tr<?php echo checkActivePage('@apply', null, false, '_selected') ?>"><?php echo link_to(__('Join Now'), '@apply') ?></dd>
            <dd class="_sp<?php echo checkActivePage('--UPGRADE', null, false, '_selected') ?>"><?php echo link_to(__('UPGRADE'), '@lobby.premium') ?></dd>
        </dl>