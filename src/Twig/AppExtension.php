<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppExtension extends AbstractExtension
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('time_ago', [$this, 'timeAgo']),
        ];
    }

    public function timeAgo($datetime): string
    {
        if (!$datetime instanceof \DateTimeInterface) {
            return "Date inconnue";
        }

        $now = new \DateTime();
        $interval = $now->diff($datetime);

        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;

        if ($years > 0) {
            return $this->translator->trans('{1}il y a un an|]1,Inf[il y a %count% ans', ['%count%' => $years]);
        } elseif ($months > 0) {
            return $this->translator->trans('{1}il y a un mois|]1,Inf[il y a %count% mois', ['%count%' => $months]);
        } elseif ($days > 0) {
            return $this->translator->trans('{1}il y a un jour|]1,Inf[il y a %count% jours', ['%count%' => $days]);
        } elseif ($hours > 0) {
            return $this->translator->trans('{1}il y a une heure|]1,Inf[il y a %count% heures', ['%count%' => $hours]);
        } elseif ($minutes > 0) {
            return $this->translator->trans('{1}il y a une minute|]1,Inf[il y a %count% minutes', ['%count%' => $minutes]);
        } else {
            return 'il y a quelques secondes';
        }
    }

}