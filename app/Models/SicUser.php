<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SicUser extends Model implements Authenticatable
{
    use HasFactory;

    protected $guard = 'sic';

    protected $table = 'sic_users';

    protected $fillable = [
        'cpf',
        'cnpj',
        'name',
        'birth',
        'sex',
        'phone',
        'email',
        'schooling',
        'password',
        'slug',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Método para retornar o nome da coluna que armazena o ID do usuário
    public function getAuthIdentifierName()
    {
        return 'id'; // Por padrão, o ID do usuário é armazenado na coluna 'id'
    }

    // Método para retornar o ID do usuário
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Retorna o valor da chave primária (normalmente 'id')
    }

    // Método para retornar a senha do usuário
    public function getAuthPassword()
    {
        return $this->password; // Retorna a senha do usuário (campo 'password' no banco de dados)
    }

    // Método para verificar se a senha fornecida corresponde à senha do usuário
    public function getRememberToken()
    {
        return $this->remember_token; // Retorna o token de "lembrar-me" (se estiver em uso)
    }

    // Método para definir o token de "lembrar-me"
    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Define o token de "lembrar-me" (se estiver em uso)
    }

    // Método para retornar o nome da coluna que armazena o token de "lembrar-me"
    public function getRememberTokenName()
    {
        return 'remember_token'; // Nome da coluna no banco de dados para o token de "lembrar-me"
    }
}
