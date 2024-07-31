<?php

namespace App\Services\Decorations;

use App\Services\Decorations\Repositories\DecorationRepositoryInterface;

class DecorationsService
{
    private DecorationRepositoryInterface $decorationRepository;

    private array $default = [
       'font_size' => 28,
        'logo' => 'logos/default.png',
        'include_borrowings_table' => true,
        'hide_work_load_date' => true,
        'hide_protection_date' => true,
        'hide_portfolio_from_checkers' => true
    ];

     public function __construct(DecorationRepositoryInterface $decorationRepository)
     {
         $this->decorationRepository = $decorationRepository;
     }

     public function get(int $organizationId)
     {
         $decoration = $this->decorationRepository->get($organizationId);
         if($decoration)
         {
             return $decoration;
         }
         else
         {

         }
     }

}
