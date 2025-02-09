<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Component\Attribute\Model;

class AttributeValue implements AttributeValueInterface
{
    /** @var mixed */
    protected $id;

    protected ?AttributeSubjectInterface $subject = null;

    protected ?AttributeInterface $attribute = null;

    protected ?string $localeCode = null;

    private ?string $text = null;

    private ?bool $boolean = null;

    private ?int $integer = null;

    private ?float $float = null;

    private ?\DateTimeInterface $datetime = null;

    private ?\DateTimeInterface $date = null;

    private ?array $json = null;

    public function getId()
    {
        return $this->id;
    }

    public function getSubject(): ?AttributeSubjectInterface
    {
        return $this->subject;
    }

    public function setSubject(?AttributeSubjectInterface $subject): void
    {
        $this->subject = $subject;
    }

    public function getAttribute(): ?AttributeInterface
    {
        return $this->attribute;
    }

    public function setAttribute(?AttributeInterface $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getLocaleCode(): ?string
    {
        return $this->localeCode;
    }

    public function setLocaleCode(?string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }

    public function getValue()
    {
        if (null === $this->attribute) {
            return null;
        }

        $getter = 'get' . $this->attribute->getStorageType();

        return $this->$getter();
    }

    public function setValue($value): void
    {
        $this->assertAttributeIsSet();

        $setter = 'set' . $this->attribute->getStorageType();

        $this->$setter($value);
    }

    public function getCode(): ?string
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getCode();
    }

    public function getName(): ?string
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getName();
    }

    public function getType(): ?string
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getType();
    }

    protected function getBoolean(): ?bool
    {
        return $this->boolean;
    }

    protected function setBoolean(?bool $boolean): void
    {
        $this->boolean = $boolean;
    }

    protected function getText(): ?string
    {
        return $this->text;
    }

    protected function setText(?string $text): void
    {
        $this->text = $text;
    }

    protected function getInteger(): ?int
    {
        return $this->integer;
    }

    protected function setInteger(?int $integer): void
    {
        $this->integer = $integer;
    }

    protected function getFloat(): ?float
    {
        return $this->float;
    }

    protected function setFloat(?float $float): void
    {
        $this->float = $float;
    }

    protected function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    /**
     * @param \DateTimeInterface $datetime
     */
    protected function setDatetime(?\DateTimeInterface $datetime): void
    {
        $this->datetime = $datetime;
    }

    protected function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    protected function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    protected function getJson(): ?array
    {
        return $this->json;
    }

    protected function setJson(?array $json): void
    {
        $this->json = $json;
    }

    /**
     * @throws \BadMethodCallException
     */
    protected function assertAttributeIsSet()
    {
        if (null === $this->attribute) {
            throw new \BadMethodCallException('The attribute is undefined, so you cannot access proxy methods.');
        }
    }
}
