<?php

namespace Wawaiguntang\Satusehat\DTOs\QuestionnaireResponse;

/**
 * FHIR R4 - QuestionnaireResponse.item
 * @see https://www.hl7.org/fhir/questionnaireresponse-definitions.html#QuestionnaireResponse.item
 *
 * Satu item jawaban dalam QuestionnaireResponse.
 * Mendukung tipe jawaban: valueCoding, valueString, valueBoolean, valueDecimal, valueInteger.
 *
 * Kode sistem menggunakan CodeSystem yang didefinisikan oleh Questionnaire yang direferensikan,
 * contoh: http://terminology.kemkes.go.id/CodeSystem/keluarga-sejahtera
 */
class QuestionnaireResponseItemDTO
{
    public function __construct(
        /** @var string ID pertanyaan (linkId dari Questionnaire) */
        public readonly string $linkId,

        /** @var string|null Teks pertanyaan */
        public readonly ?string $text = null,

        /** @var string|null Sistem kode untuk valueCoding */
        public readonly ?string $valueCodingSystem = null,

        /** @var string|null Kode jawaban (valueCoding) */
        public readonly ?string $valueCodingCode = null,

        /** @var string|null Display jawaban (valueCoding) */
        public readonly ?string $valueCodingDisplay = null,

        /** @var string|null Jawaban teks bebas (valueString) */
        public readonly ?string $valueString = null,

        /** @var bool|null Jawaban boolean (valueBoolean) */
        public readonly ?bool $valueBoolean = null,

        /** @var float|null Jawaban desimal (valueDecimal) */
        public readonly ?float $valueDecimal = null,

        /** @var int|null Jawaban integer (valueInteger) */
        public readonly ?int $valueInteger = null,
    ) {}

    public function toArray(): array
    {
        $item = [];

        if ($this->text !== null) {
            $item['text'] = $this->text;
        }

        $answer = [];
        if ($this->valueCodingCode !== null) {
            $coding = ['code' => $this->valueCodingCode];
            if ($this->valueCodingSystem !== null) {
                $coding['system'] = $this->valueCodingSystem;
            }
            if ($this->valueCodingDisplay !== null) {
                $coding['display'] = $this->valueCodingDisplay;
            }
            $answer[] = ['valueCoding' => $coding];
        } elseif ($this->valueString !== null) {
            $answer[] = ['valueString' => $this->valueString];
        } elseif ($this->valueBoolean !== null) {
            $answer[] = ['valueBoolean' => $this->valueBoolean];
        } elseif ($this->valueDecimal !== null) {
            $answer[] = ['valueDecimal' => $this->valueDecimal];
        } elseif ($this->valueInteger !== null) {
            $answer[] = ['valueInteger' => $this->valueInteger];
        }

        $data = ['linkId' => $this->linkId];
        if (!empty($item['text'])) {
            $data['text'] = $item['text'];
        }
        if (!empty($answer)) {
            $data['answer'] = $answer;
        }

        return $data;
    }
}
