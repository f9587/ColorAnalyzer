<?php

use Nette\Application\UI\Form;
use Nette\Utils\Validators;
/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
    /**@var type PictureAnalyzer\WebpagesRepository*/
    private $webpagesRepository;
    
    /**@var type PictureAnalyzer\ColorsRepository*/
    private $colorsRepository;
    
     /**@var type PictureAnalyzer\PicturesRepository*/
    private $picturesRepository;
    
    public function inject(PictureAnalyzer\WebpagesRepository $webpagesRepository,
                           PictureAnalyzer\ColorsRepository $colorsRepository,
                           PictureAnalyzer\PicturesRepository $picturesRepository)
    {
        $this->webpagesRepository= $webpagesRepository;
        $this->colorsRepository=$colorsRepository;
        $this->picturesRepository=$picturesRepository;
    }
                
    public function renderDefault()
    {
        $this->template->colors = $this->colorsRepository->getTopColors();
    }

    public function actionCron()
    {
        if (!$this->getContext()->params['consoleMode']) {
            throw new AuthenticationException;
        }
        $this->picturesRepository->updateData();   
        $this->terminate();
    }
    
    /**
     * @return Nette\Application\UI\Form
     */
    protected function createComponentWebpageForm()
    {
        $form = new Form();
        $urlFilter = function ($value) {
            return Validators::isUrl($value) ? $value : "http://" . $value;
        };
        
        $form->addText('url', 'URL', 40, 100)
           ->addFilter($urlFilter)
          ->addCondition(Form::FILLED)
          ->addRule(Form::URL, 'Nebylo zadáno platné URL');
        $form->addSubmit('submit', 'Přidat');
        $form->onSuccess[] = $this->webpageFormSubmitted;
        return $form;
    }
    
    public function webpageFormSubmitted(Form $form)
    {
        $values=$form->getValues();
        $page_header=@get_headers($values['url']);
        if (is_array($page_header) && preg_match("/200 OK$/",$page_header[0])){
            if ($this->webpagesRepository->addWebpage($form->values->url)){
                $this->flashMessage('URL přidáno.', 'success');
                $this->redirect('this');
            }else {
                $form->addError('Tato stránka již byla vložena');
            }
        }else{
            $form->addError('Tato stránka není dostupná');
        }
        
    }

}
