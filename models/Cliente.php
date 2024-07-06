<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Cliente extends ActiveRecord
{
    public static function tableName()
    {
        return 'cliente';
    }

    public function rules()
    {
        return [
            [['nome', 'cpf', 'cep', 'logradouro', 'numero', 'cidade', 'estado', 'sexo', 'foto'], 'required'],
            [['cpf'], 'unique'],
            [['nome', 'logradouro', 'cidade', 'estado', 'complemento', 'foto'], 'string', 'max' => 255],
            [['cpf'], 'string', 'max' => 11],
            [['cep'], 'string', 'max' => 8],
            [['numero'], 'integer'],
            [['sexo'], 'string', 'max' => 1],
            [['cpf'], 'validateCpf'],
        ];
    }

    public function validateCpf($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->isValidCpf($this->$attribute)) {
                $this->addError($attribute, 'CPF inválido.');
            }
        }
    }

    private function isValidCpf($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
