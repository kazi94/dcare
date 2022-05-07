<?php

namespace App\Repository;

use App\Models\LigneDevis;

class LigneDevisRepo
{
    /**
     * Create a new quotation line
     *
     * @param object $line
     * @param int $quot_id
     * @return \App\Models\LigneDevis
     */
    public function create($line, $quot_id)
    {
        return
            LigneDevis::create([
                'devis_id'  => $quot_id,
                'num_dent'  => $line->tooth,
                'acte_id'   => $line->act_id,
                'price'     => $line->price,
                'state'     => "A faire",

            ]);
    }
    /**
     * change the state of accepted and rejected lines
     *
     * @param array $ids
     * @return void
     */
    public function updateAcceptedStateByLinesID($ids)
    {
        LigneDevis::whereIn('id', $ids)->update([
            'accepted_state' => true
        ]);

        // LigneDevis::whereNotIn('id', $ids)->update([
        //     'accepted_state' => false
        // ]);
        return;
    }
    /**
     * Return Lignes devis model with eager loading relations and IDS
     *
     * @param array $relations
     * @param array $ids
     * @return \App\Models\LigneDevis
     */
    public function getByIdsWith($relations, $ids)
    {
        return
            LigneDevis::with('act.coords', 'act.videos')->whereIn('id', $ids)->get();
    }

    /**
     * Count the number of actes by the date of creation
     *
     * @param date $date
     * @return int
     */
    public function countByCreatedDate($date)
    {
        return LigneDevis::whereDate('updated_at', $date)->whereState('Fait')->count();
    }
    /**
     * Get the number of acts group by update date
     * between a range of period
     * @param string $state
     * @param [type] $period
     * @return void
     */
    public function countActsGroupByUpdatedDate($state = "fait", $period)
    {
        return LigneDevis::whereState($state)
            ->whereBetween(\DB::raw("DATE(updated_at)"), $period)
            ->groupBy("month")
            ->select(
                \DB::raw("count('state') as nbrActs"),
                \DB::raw(" MONTHNAME(updated_at) as month")
            )->get();
    }
    /**
     * Count the number of acts group by dates of update
     * for the current month
     * @param string $state
     * @return void
     */
    public function countActsGroupByUpdatedDateForCurrentMonth($state = "fait")
    {
        return LigneDevis::whereState($state)
            ->where(\DB::raw("CAST(updated_at AS DATE)"), "<=", \Carbon\Carbon::today()->toDateString())
            ->where(\DB::raw("CAST(updated_at AS DATE)"), ">=", \Carbon\Carbon::now()->startOfMonth())
            ->groupBy('month')
            ->select(
                \DB::raw("count('state') as nbrActs"),
                \DB::raw(" MONTHNAME(updated_at) as month")
            )->get();
    }
    /**
     * Count the number of acts of the current month
     * group by the state of the act
     * @param string $state
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function countActsOfTheCurrentMonthByState($state = "fait")
    {
        return LigneDevis::with('act')->whereState($state)
            ->where(\DB::raw("CAST(updated_at AS DATE)"), "<=", \Carbon\Carbon::today()->toDateString())
            ->where(\DB::raw("CAST(updated_at AS DATE)"), ">=", \Carbon\Carbon::now()->startOfMonth())
            ->groupBy('acte_id')
            ->select(
                \DB::raw("count('acte_id') as nbrActs"),
                "acte_id"

            )->get();
    }
    /**
     * Count the number of acts between two period
     * group by the state of the act
     * @param string $state
     * @param array $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function countActsBetweenPeriodByState($state = "fait", $period)
    {
        return LigneDevis::with('act')->whereState($state)
            ->whereBetween(\DB::raw("CAST(updated_at AS DATE)"), $period)
            ->groupBy('acte_id')
            ->select(
                \DB::raw("count('acte_id') as nbrActs"),
                "acte_id"

            )->get();
    }
    /**
     * Calculate sum of acts group by category 
     * for the current month
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function sumActsPerCategoryOfTheCurrentMonth($state)
    {
        return LigneDevis::join('actes', 'actes.id', 'acte_id')
            ->join('categories', 'categories.id', 'actes.category_id')
            ->where(\DB::raw("CAST(updated_at AS DATE)"), "<=", \Carbon\Carbon::today()->toDateString())
            ->where(\DB::raw("CAST(updated_at AS DATE)"), ">=", \Carbon\Carbon::now()->startOfMonth()->toDateString())
            ->whereState($state)
            ->groupBy('categories.name', 'categories.color')
            ->select(
                \DB::raw("SUM(lignedevis.price) as totalPrice"),
                \DB::raw("categories.name as categoryName"),
                \DB::raw("categories.color as color")
            )->get();
    }
    /**
     * Calculate sum of acts  group by category
     * between a range of period
     * @param array $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function sumActsPerCategoryBetweenPeriod($state, $period)
    {
        return LigneDevis::join('actes', 'actes.id', 'acte_id')
            ->join('categories', 'categories.id', 'actes.category_id')
            ->whereBetween(\DB::raw("CAST(updated_at AS DATE)"), $period)
            ->whereState($state)
            ->groupBy('categories.name', 'categories.color')
            ->select(
                \DB::raw("SUM(lignedevis.price) as totalPrice"),
                \DB::raw("categories.name as categoryName"),
                \DB::raw("categories.color as color")
            )->get();
    }
    /**
     * Calculate sum of acts  
     * for the current month
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function sumActsOfTheCurrentMonth($state)
    {
        return LigneDevis::join('actes', 'actes.id', 'lignedevis.acte_id')
            ->whereState($state)
            ->where(\DB::raw("CAST(updated_at AS DATE)"), "<=", \Carbon\Carbon::today()->toDateString())
            ->where(\DB::raw("CAST(updated_at AS DATE)"), ">=", \Carbon\Carbon::now()->startOfMonth()->toDateString())
            ->groupBy('lignedevis.acte_id')
            ->select(
                \DB::raw("COUNT(lignedevis.acte_id) as nbrActs"),
                \DB::raw("SUM(lignedevis.price) as total"),
                \DB::raw("actes.nom as name")
            )->get();
    }


    /**
     * Calculate sum of acts 
     * between a range of period
     * @param array $period
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return 
     */
    public function sumActsBetweenPeriod($state, $period)
    {
        return LigneDevis::join('actes', 'actes.id', 'lignedevis.acte_id')
            ->whereState($state)
            ->whereBetween(\DB::raw("CAST(updated_at AS DATE)"), $period)
            ->groupBy('lignedevis.acte_id')
            ->select(
                \DB::raw("COUNT(lignedevis.acte_id) as nbrActs"),
                \DB::raw("SUM(lignedevis.price) as total"),
                \DB::raw("actes.nom as name")
            )->get();
    }
}
