<?php
namespace UI\UiProvider\ViewHelpers\Page\Header;

use FluidTYPO3\Vhs\Traits\TagViewHelperTrait;
use FluidTYPO3\Vhs\Traits\PageRendererTrait;

/**
 * ViewHelper used to render a meta tag
 *
 * If you use the ViewHelper in a plugin it has to be USER
 * not USER_INT, what means it has to be cached!
 *
 * @deprecated Deprecated in Version 9 of ui_provider. Will be removed in Version 10. Use the more general MetaTagsViewHelper
 */
class MetaViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    use TagViewHelperTrait;
    use PageRendererTrait;

    /**
     * @var    string
     */
    protected $tagName = 'meta';

    /**
     * Arguments initialization
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('name', 'string', 'Name property of meta tag');
        $this->registerTagAttribute('property', 'string', 'Property of meta tag');
        $this->registerTagAttribute('content', 'string', 'Content of meta tag');
        $this->registerTagAttribute('http-equiv', 'string', 'Property: http-equiv');
        $this->registerTagAttribute('scheme', 'string', 'Property: scheme');
        $this->registerTagAttribute('lang', 'string', 'Property: lang');
        $this->registerTagAttribute('dir', 'string', 'Property: dir');
    }

    /**
     * Render method
     *
     * @return void
     */
    public function render()
    {
        if ('BE' === TYPO3_MODE) {
            return;
        }
        if (true === isset($this->arguments['content']) && false === empty($this->arguments['content'])) {

            $test = preg_replace('/content=".*"/', 'content=".*"', $this->renderTag($this->tagName, null, ['content' => $this->arguments['content']]));

            $this->getPageRenderer()
                ->replaceMetaTag($test, $this->renderTag($this->tagName, null, ['content' => $this->arguments['content']]));
                //->addMetaTag($this->renderTag($this->tagName, null, ['content' => $this->arguments['content']]));
        }
    }
}