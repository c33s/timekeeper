<?php

namespace Phpactor\Extension\Timekeeper\Adapter\Hoa;

use DateTimeImmutable;
use Hoa\Compiler\Llk\TreeNode;
use Phpactor\Extension\Timekeeper\Domain\Date;
use Phpactor\Extension\Timekeeper\Domain\Builder\DateBuilder;
use Phpactor\Extension\Timekeeper\Domain\Builder\EntryBuilder;
use Phpactor\Extension\Timekeeper\Domain\Builder\TimesheetBuilder;
use Phpactor\Extension\Timekeeper\Domain\Entry;
use Phpactor\Extension\Timekeeper\Domain\Exception\DefectException;
use Phpactor\Extension\Timekeeper\Domain\Timesheet;

class TimesheetWalker
{
    const NODE_CATEGORY = '#category';
    const NODE_DATE = '#date';
    const NODE_ENTRY = '#entry';
    const NODE_ENTRY_LINE = '#entryline';
    const NODE_TAG = '#tag';

    const TOKEN_DATE = 'date';
    const TOKEN_TEXT = 'text';
    const TOKEN_TIME = 'time';

    public function walk(TreeNode $node)
    {
        $builder = new TimesheetBuilder();

        foreach ($node->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getId() === self::NODE_DATE) {
                $builder->addDate($this->walkDate($childNode));
            }
        }

        return $builder->build();
    }

    private function walkDate(TreeNode $node): Date
    {
        $date = $node->getValue();
        $builder = new DateBuilder();

        foreach ($node->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getValueToken() === self::TOKEN_DATE) {
                $builder->date(new DateTimeImmutable($childNode->getValueValue()));
                continue;
            }

            if ($childNode->getId() == self::NODE_ENTRY_LINE) {
                $builder->addEntry($this->walkEntryLine($childNode));
                continue;
            }


        }

        return $builder->build();
    }

    private function walkEntryLine(TreeNode $node): Entry
    {
        $date = $node->getValue();

        foreach ($node->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getId() === self::NODE_ENTRY) {
                return $this->walkEntry($childNode);
            }
        }
    }

    private function walkEntry(TreeNode $childNode): Entry
    {
        $builder = new EntryBuilder();

        foreach ($childNode->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getValueToken() === self::TOKEN_TIME) {
                $builder->time($childNode->getValueValue());
                continue;
            }

            if ($childNode->getValueToken() === self::TOKEN_TEXT) {
                $builder->comment(trim($childNode->getValueValue()));
                continue;
            }

            if ($childNode->getId() === self::NODE_CATEGORY) {
                $builder->category($this->walkCategory($childNode));
                continue;
            }

            if ($childNode->getId() === self::NODE_TAG) {
                $builder->addTag($this->walkTag($childNode));
                continue;
            }
        }

        return $builder->build();
    }

    private function walkCategory(TreeNode $node): string
    {
        foreach ($node->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getValueToken() === 'name') {
                return $childNode->getValueValue();
            }
        }

        throw new DefectException('Category has no name');
    }

    private function walkTag(TreeNode $node)
    {
        foreach ($node->getChildren() as $childNode) {
            assert($childNode instanceof TreeNode);

            if ($childNode->getValueToken() === 'tag') {
                return ltrim($childNode->getValueValue(), '@');
            }
        }

        throw new DefectException('Tag has no name');
    }
}
