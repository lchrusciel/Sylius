<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\Import\Writer\ORM;

use Sylius\Component\ImportExport\Writer\WriterInterface;

/**
 * Export reader.
 *
 * @author Bartosz Siejka <bartosz.siejka@lakion.com>
 */
abstract class AbstractDoctrineWriter implements WriterInterface
{
    private $results;
    private $running = false;
    private $configuration;
    
    public function write()
    {
        if (!$this->running)
        {
            $this->running =true;
            $this->results = $this->getQuery()->execute();
            $this->results = new \ArrayIterator($this->results);
            $batchSize = $this->configuration['batch_size'];
        }
        
        $results = array();

        for ($i=0; $i<$batchSize; $i++)
        {
            if ($result = $this->results->current())
            {
                $this->results->next();
            }
            
            $result = $this->process($result);
            $results[] = $result;
        }
        
        return $results;
    }

    public function setConfiguration (array $configuration)
    {
        $this->configuration = $configuration;
    }  

    public abstract function process($result);
}