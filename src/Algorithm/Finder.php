<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $_persons;

    public function __construct(array $persons)
    {
        $this->_persons = $persons;
    }

    /**
     * @param int $finderType
     * @return PersonsAgeDifferent
     */
    public function find(int $finderType): PersonsAgeDifferent
    {
        $personsAgeDifferences = $this->definePersonsAgeDifferent();

        if (count($personsAgeDifferences) < 1) {
            return new PersonsAgeDifferent();
        }

        $answer = $this->searchPersonsAgeDifferentByFinderType($finderType, $personsAgeDifferences);

        return $answer;
    }

    /**
     * @return array
     */
    public function definePersonsAgeDifferent()
    {
        $personsAgeDifferences = [];

        for ($i = 0; $i < count($this->_persons); $i++) {
            for ($j = $i + 1; $j < count($this->_persons); $j++) {
                $personsAgeDifferent = new PersonsAgeDifferent();

                if ($this->_persons[$i]->birthDate < $this->_persons[$j]->birthDate) {
                    $personsAgeDifferent->person1 = $this->_persons[$i];
                    $personsAgeDifferent->person2 = $this->_persons[$j];
                } else {
                    $personsAgeDifferent->person1 = $this->_persons[$j];
                    $personsAgeDifferent->person2 = $this->_persons[$i];
                }

                $personsAgeDifferent->ageDifferent =
                    $personsAgeDifferent->person2->birthDate->getTimestamp() - $personsAgeDifferent->person1->birthDate->getTimestamp();

                $personsAgeDifferences[] = $personsAgeDifferent;
            }
        }

        return $personsAgeDifferences;

    }

    /**
     * @param int $finderType
     * @param $personsAgeDifferences
     * @return mixed
     */
    public function searchPersonsAgeDifferentByFinderType(int $finderType, $personsAgeDifferences)
    {
        $answer = $personsAgeDifferences[0];

        foreach ($personsAgeDifferences as $item) {
            switch ($finderType) {
                case FinderType::CLOSEST:
                    if ($item->ageDifferent < $answer->ageDifferent) {
                        $answer = $item;
                    }
                    break;

                case FinderType::FURTHEST:
                    if ($item->ageDifferent > $answer->ageDifferent) {
                        $answer = $item;
                    }
                    break;
            }
        }

        return $answer;
    }
}
