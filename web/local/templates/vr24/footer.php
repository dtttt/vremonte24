<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>


    <footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <?Tools\Vr24\Common::statInstructions()?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?Tools\Vr24\Common::statParts()?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <?Tools\Vr24\Common::statAnswers()?>
            </div>
        </div>
    </div>
    <hr class="hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:menu",
                    "bottom",
                    Tools\Params\Menu::bottom()
                );?>
            </div>
            <div class="col-xs-12 col-sm-2">
                <button class="btn btn-block btn-transparent obratnaya-svyaz">Обратная связь</button>
                <?$APPLICATION->IncludeFile('/includes/siteFooterMiVSocsetyah.php')?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?$GLOBALS['APPLICATION']->IncludeComponent(
                    "bitrix:search.form",
                    "bottom",
                    Tools\Params\SearchForm::bottom()
                );?>
                <?$APPLICATION->IncludeFile('/includes/siteFooterSposobiOplati.php')?>
                <?$APPLICATION->IncludeFile('/includes/siteFooterRazrabotkaSaita.php')?>
            </div>
        </div>
    </div>
    <div class="container footer-padding"></div>
</footer>
</body>
</html>