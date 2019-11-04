<?php

namespace Goondi\ToolsBundle\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Container;

class DataTable
{
    private $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     *
     * Generate DataTable with Pagination and Json structure for Javascript Datatables Jquery Plugin
     *
     * http://www.datatables.net/
     *
     *
     * @param Array $columns :
     *  Exemple : array(
     *                  'label' => 'name',
     *                  'id' => 'mv.name',
     *                  'method' => array(
     *                      'firstMethod',
     *                      'secondMethod'
     *                  )
     *            )
     * @param QueryBuilder $queryBuilder : query doctrine generation
     * @param Integer $pageSize : number of elements in one page
     * @param Integer $start : first element of the page
     * @param Array $orders : array(
     *                  array('column' => 'column1', 'dir' => 'ASC'),
     *                  array('column' => 'column2', 'dir' => 'DESC')
     *                  )
     * @param Array $columnsFilters : array sent by datatable
     * @param Array $filters : array sent by datatable
     *
     * @return Array : result data in a table
     */
    public function generateTable($columns, $queryBuilder, $pageSize, $start, $orders, $columnsFilters, $filters, $rowPrefix = null)
    {

        // Convert $columns workshopciate array to numeric array
        $cols = array();
        foreach ($columns as $column) {
            $cols[] = $column;
        }

        /* TODO
         * Is There a column filter to apply
        if(isset($columnsFilters) && is_array($columnsFilters))
        {
            foreach($columnsFilters as $key => $columnsFilter)
            {
                if(isset($columnsFilter['search']) && isset($columnsFilter['search']['value']) && $columnsFilter['search']['value'] != '')
                {
                    if(isset($columnsFilter['search']['value']) && $columnsFilter['search']['regex'])
                    {
                        $queryBuilder->andWhere($columns[$key]['id'].' REGEXP '.$columnsFilter['search']['value']);
                    }
                }
            }
        }*/


        // Is There global filters
        if (is_array($filters) && count($filters)) {
            $counter = 10000;
            foreach ($filters as $keyFilter => $valueFilter) {
                if (is_array($valueFilter) && count($valueFilter)) {
                    $parameter = array();
                    $orx = $queryBuilder->expr()->orx();
                    foreach ($valueFilter as $f) {
                        if (!is_array($columns[$keyFilter]['id'])) {
                            if ($f == 'null') {
                                $orx->add($columns[$keyFilter]['id'] . ' IS NULL');
                            } else {
                                $orx->add($queryBuilder->expr()->eq($columns[$keyFilter]['id'], '?' . $counter));
                                $parameter[$counter] = $f;
                                $counter++;
                            }
                        }
                    }
                    $queryBuilder->andWhere($orx);
                    foreach ($parameter as $keyParam => $valueParam) {
                        $queryBuilder->setParameter($keyParam, $valueParam);
                    }
                }
            }
        }

        // Is There an order to apply
        if (is_array($orders) && count($orders)) {
            foreach ($orders as $order) {
                if (isset($order['column']) && isset($cols[$order['column']])) {
                    if (is_array($cols[$order['column']]['id'])) {
                        foreach ($cols[$order['column']]['id'] as $colId) {
                            $queryBuilder->addOrderBy($colId, $order['dir']);
                        }
                    } else {
                        $queryBuilder->addOrderBy($cols[$order['column']]['id'], $order['dir']);
                    }
                }
            }
        }

        // Pagination old System only works with object in select
//        $queryBuilder->setFirstResult($start)->setMaxResults($pageSize);
//        $records = new Paginator($queryBuilder);
//        $recordsTotal = $records->count();

        // Pagination new system
        // Dans le nouveau system de pagination $start n'est pas le premier élément à afficher mais le numéro de la page à afficher

        if (!$pageSize) {
            $pageSize = 50;
        }
        if (!$start) {
            $start = 1;
        } else {
            $start = ceil(($start + 1) / $pageSize);
        }

        $paginator = $this->container->get('knp_paginator');
        /**
         * Wrap-queries utilisé en suivant la doc
         * " If you want to order your results by a column from a fetch joined t-many association, you have to set wrap-queries to true. Otherwise you will get an exception with this warning: "Cannot select distinct identifiers from query with LIMIT and ORDER BY on a column from a fetch joined to-many association. Use output walkers."
         *  https://github.com/KnpLabs/knp-components/blob/master/doc/pager/config.md
         */
        $pagination = $paginator->paginate(
            $queryBuilder,
            $start,
            $pageSize,
            ['wrap-queries' => true]
        );

        $recordsTotal = $pagination->getTotalItemCount();
        $records = $pagination;

        if ($rowPrefix === null) {
            $rowPrefix = 'row_';
        }

        // Format Datas
        $data = array();
        foreach ($records as $record) {
            $tmp = array();
            if (is_array($record)) {
                $tmp['DT_RowId'] = $rowPrefix . $record['id'];
                $tmp['DT_RowData']['pkey'] = $record['id'];
            } else {
                $tmp['DT_RowId'] = $rowPrefix . $record->getId();
                $tmp['DT_RowData']['pkey'] = $record->getId();
            }

            foreach ($columns as $c) {
                $o = '';
                if (isset($c['method']) && is_array($c['method']) && count($c['method'])) {
                    $r = $record;
                    foreach ($c['method'] as $method) {
                        if ($r && is_array($r)) {
                            $r = $r[$method];
                        } else if ($r && !is_array($r)) {
                            if (is_array($method) && isset($method[0])) {
                                /**
                                 * Utilisé pour les tables associative par exemple lorsque l'on veut faire ca : $item->getActivies()[0], on met donc un array avec getActivities en première case et 0 en deuxième case
                                 */
                                $r = $r->{$method[0]}()[$method[1]];
                            } else {
                                $r = $r->$method();
                            }
                        } else {
                            $r = '';
                        }
                    }
                    $o = $r;
                }

                if (isset($c['filter']) && is_array($c['filter']) && count($c['filter'])) {
                    foreach ($c['filter'] as $filter) {
                        if (is_object($o) && !is_null($o)) {
                            $o = call_user_func_array(array($o, $filter['name']), $filter['args']);
                        } else if (!is_null($o)) {
                            if (isset($filter['args']) && is_array($filter['args'])) {
                                $o = call_user_func_array($filter['name'], array_merge(array($o), $filter['args']));
                            } else {
                                $o = call_user_func_array($filter['name'], array($o));
                            }
                        }
                    }
                }

                $tmp[$c['label']] = $o;
            }
            $data[] = $tmp;
        }

        return array(
            'recordsTotal' => $recordsTotal,
            'data' => $data
        );
    }

}
