<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require ( "SphinxClient.php" );
require ( "fsphinxapi.php" );

use FSphinx\FSphinxClient;
use FSphinx\MultiFieldQuery;
use FSphinx\Facet;

class FSphinxLib {

    public function create()
    {
		//return FSphinx\FSphinxClient::fromConfig('config.sample.php');
		$cl = new FSphinxClient();
		$cl->setServer(defined('SPHINX_HOST') ? SPHINX_HOST : '127.0.0.1', defined('SPHINX_PORT') ? SPHINX_PORT : 9312);
		$cl->setDefaultIndex('ygecom');
		$cl->setMatchMode(FSphinxClient::SPH_MATCH_EXTENDED2);
		$cl->setSortMode(FSphinxClient::SPH_SORT_EXPR, '@weight * 1');
		$cl->setFieldWeights(array('nama_produk' => 30));
		//$factor = new Facet('actor');
		//$factor->attachDataSource($cl, array('name' => 'actor_terms'));
		$fdirector = new Facet('genre');
		$fdirector->attachDataSource($fdirector, array('name' => 'genre_terms_attr'));
		$cl->attachFacets(
			//new Facet('year'),
			//new Facet('genre'),
			//new Facet('keyword', array('attr' => 'plot_keyword_attr')),
			$fdirector
			//$factor
		);
		$group_func = 'sum(100)';
		foreach ($cl->facets as $facet) {
			$facet->setGroupFunc($group_func);
			//$facet->setOrderBy('@term', 'asc');
			$facet->setOrderBy('@groupfunc', 'desc');
			$facet->setMaxNumValues(5);
			
		}
		$cl->attachQueryParser(
			new MultiFieldQuery(
				array(
					'genre' => 'genres',
					//'keyword' => 'plot_keywords',
					//'director' => 'directors',
					//'actor' => 'actors'
				)
			)
		);

		return $cl;
    }
}

/* End of file FSphinxLib.php */
