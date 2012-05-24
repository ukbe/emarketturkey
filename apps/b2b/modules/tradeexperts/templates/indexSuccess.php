<div class="col_948">
<div class="presentation">

    <div class="boxTitle">
        <h2>
            TRADE Experts <sup>&reg;</sup>
        </h2>
    </div>

    <div class="boxContent tabs noBorder">

        <dl class="_trade_expert-01">
            <dt>JUMP INTO ANSWERS</dt>
            <dd>
                Join <strong class="emt">eMarketTurkey <sup>&reg;</sup></strong> today,<br /> 
                get help from a <em>TRADE EXPERT</em>.
                <ul>
                    <li><a href="sdfg">Who are trade experts?</a></li>
                    <li><a href="asdf">What is <strong class="emt">eMarketTurkey <sup>&reg;</sup> TRADE Experts <sup>&reg;</sup></strong>program?</a></li>
                    <li><a href="dfgh">How can you reach a trade expert?</a></li>
                </ul>
            </dd>
        </dl>
        <dl class="_trade_expert-02">
            <dt>MINIMIZE RISKS</dt>
            <dd>
                Improve your <em>efficiency</em> and minimize risks
                through our global network of agents and solution providers.
            </dd>
        </dl>
        <dl class="_trade_expert-03">
            <dt>JOIN US!</dt>
            <dd>
                Choosing a suitable role and region,
                you are now 1-step closer to become <em>Trade Expert</em> 
            </dd>
        </dl>

    </div>

    <div class="slidetabs">
        <a href="#">Qualified Trade Experts</a>
        <a href="#">Improve Your Operational Capability</a>
        <a href="#">Become a Trade Expert</a>
    </div>
</div>

    <div class="col_657 presentation">
        <div class="box_657 pad-3 boxContent noBorder">
        <h2><abbr>TR</abbr>ADE EXPERTS</h2>
        <q>
            Any member or company can create a <strong class="emt">Trade Expert <sup>&reg;</sup></strong> 
            account for free. All it takes is to attract visitor focus and provide them with the
            expertise they need. The more popularity one has, the more inquiries, thus, <em>jobs</em> he will get!
        </q>
        <p>
            <span class="firstLetter"><span><strong class="ui-corner-all">I</strong></span></span>nternational
            trade is exchange of capital, goods, and services across international 
            borders or territories. In most countries, it represents a significant 
            portion of the gross domestic product - GDP, giving rise to a whole new 
            employment area at which the flow of commerce is supported by localized 
            and highly specilized assisting services. International trade is in 
            principle not different from domestic trade as the motivation and the 
            behavior of parties involved in a trade do not change fundamentally 
            regardless of whether trade is across a border or not. The main difference 
            is that international trade is typically more costly than domestic trade. 
            The reason is that a border typically imposes additional costs such as 
            tariffs, time costs due to border delays and costs associated with country 
            differences such as language, the legal system or culture. In international
            trade, learning by experience is a costly one, something to be avoided
            most delicately, and professionally. 
        </p>
        <h4 class="noBorder">Who Are Trade Experts?</h4>
        <p>
            Solutions to such problems require trusted parties in the form of 
            "<strong>Business Agents</strong>" or "<strong>Solution Providers</strong>",
            either of which are the contracted individuals and / or group of people 
            posessing certain skills and knowledge, and operational capability at 
            the remote target locations, who may 
            assist or initiate the commerce by acting on behalf of other companies.
        </p>
        <p>
            Basically, there are three types of <strong>Trade Experts</strong> 
            which are described within <strong class="emt">eMarketTurkey 
            <sup>&reg;</sup></strong> business scope:
        </p>
        </div>
    </div>
    
    <div class="col_285">
        <div class="box_285 _titleBG_White">
            <h3>
                <?php echo __('Become a Trade Expert') ?>
            </h3>
            <div>
            <p>
                <?php echo __('We encourage professionals and skilled organisations to join our Trade Experts directory.') ?>
            </p>
            <p>
                <?php echo __('In order to get listed in Trade Experts directory, you should apply for a Trade Experts account.') ?>
                <div class="txtCenter">
                <?php echo link_to(__('Apply Now'), '@tradeexperts-action?action=apply', 'class=dark-button') ?>
                </div> 
            </p>
            </div>
        </div>

        <div class="box_285 _titleBG_White">
            <h3>
                <?php echo __('Get Support from a Trade Expert') ?>
            </h3>
            <div>
                <p>
                    <?php echo __('Trade Experts provide you the most reliable information and also easily accessible through the Trade Experts directory.') ?> 
                </p> 
                <p>
                    <?php echo __('Take the advantage to get support from a Trade Expert, by just a few clicks.') ?> 
                <div class="txtCenter">
                <?php echo link_to(__('Find a Trade Expert'), '@tradeexperts-action?action=find', 'class=dark-button') ?>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?php echo javascript_tag("
$(function() {
    $('.slidetabs').tabs('.tabs > dl', {
        effect: 'fade',
        rotate: true
    }).slideshow({
        clickable: false,
        autoplay:true,
        interval:20000
    });
});

") ?>