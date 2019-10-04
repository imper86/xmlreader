<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 23.09.2019
 * Time: 19:47
 */

namespace Imper86\XMLReader;


class XMLReader extends \XMLReader
{
    public function getIterator(string $iterableTagName): \Iterator
    {
        while ($this->read() && $this->name !== $iterableTagName) {}

        while (true) {
            if ($this->name !== $iterableTagName) {
                if ($this->next()) {
                    continue;
                }

                break;
            }

            yield simplexml_load_string($this->readOuterXml());

            if ($this->next()) {
                continue;
            }

            break;
        }
    }

    public function findNext(string $tagName): ?\SimpleXMLElement
    {
        while ($this->read()) {
            if ($tagName === $this->name) {
                return simplexml_load_string($this->readOuterXml());
            }
        }

        return null;
    }
}
