<?php

require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Uspdev\Wsfoto;

/**
 * Função para obter e salvar uma foto a partir de um código pessoal.
 *
 * @param int $codpes O código pessoal.
 * @return string Mensagem de sucesso ou erro.
 */
function salvarFoto($codpes) {
    //echo 'foto ' . $codpes;
    
    try {
        $foto = Wsfoto::obter($codpes);

        if ($foto === null) {
            return 'Foto não encontrada.';
        }

        // Decodifica a imagem base64
        $imagemDecodificada = base64_decode($foto);

        // Define o caminho para salvar a imagem
        $caminhoArquivo = __DIR__ . '/fotos/' . $codpes . '.jpg';

        // Garante que o diretório "fotos" existe
        if (!file_exists(__DIR__ . '/fotos')) {
            mkdir(__DIR__ . '/fotos', 0777, true);
        }

        // Salva a imagem no arquivo
        file_put_contents($caminhoArquivo, $imagemDecodificada);

        return 'Foto salva com sucesso em ' . $caminhoArquivo;

    } catch (Exception $e) {
        return 'Ocorreu um erro: ' . $e->getMessage();
    }
}


