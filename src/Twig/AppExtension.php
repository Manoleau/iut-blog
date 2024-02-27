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
            return $this->translator->trans('{1}un an|]1,Inf[%count% ans', ['%count%' => $years]);
        } elseif ($months > 0) {
            return $this->translator->trans('{1}un mois|]1,Inf[%count% mois', ['%count%' => $months]);
        } elseif ($days > 0) {
            return $this->translator->trans('{1}un jour|]1,Inf[%count% jours', ['%count%' => $days]);
        } elseif ($hours > 0) {
            return $this->translator->trans('{1}une heure|]1,Inf[%count% heures', ['%count%' => $hours]);
        } elseif ($minutes > 0) {
            return $this->translator->trans('{1}une minute|]1,Inf[%count% minutes', ['%count%' => $minutes]);
        } else {
            return 'quelques secondes';
        }
    }

}