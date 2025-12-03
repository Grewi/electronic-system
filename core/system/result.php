<?php

namespace system\core\system;

class result
{
    private bool $status = true;
    private int $code = 200;
    private array $errors = [];
    private array $data = [];

    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setError(string $error): static
    {
        $this->status = false;
        $this->errors[] = $error;
        return $this;
    }

    public function setErrors(array|object $errors): static
    {
        $this->status = false;
        foreach($errors as $error){
            if(is_string($error) || is_numeric($error)){
                $this->errors[] = (string)$error;
            }
        }
        return $this;
    }    

    public function getArrayErrors(): array
    {
        return $this->errors;
    }

    public function getStringErrors(): string
    {
        return implode(', ', $this->errors);
    }

    public function setParam(string $name, mixed $value): static
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function getParam(string $name): mixed
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    public function json()
    {
        header('Content-Type: application/json');
        $data = [
          'status' => $this->status,
          'code' => $this->code,
          'errors' => $this->getArrayErrors(),
          'error'  => $this->getStringErrors(),
          'data'   => $this->data,
        ];
        return json_encode($data);
    }

    public function ajax()
    {
        http_response_code($this->code);
        echo $this->json();
        exit;
    }
}
