<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
    /**
     * @var type ColorAnalyzer\WebpagesRepository
     */
    private $webpagesRepository;
    
    public function inject(PictureAnalyzer\WebpagesRepository $webpagesRepository)
    {
        $this->webpagesRepository= $webpagesRepository;
    }


    public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
