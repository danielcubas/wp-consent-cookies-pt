<?php
/**
 * Plugin Name: Meu Consentimento de Cookies
 * Plugin URI: https://qoding.com.br
 * Description: Um plugin de WordPress para adicionar um disclaimer de consentimento de cookies.
 * Version: 1.3
 * Author: Daniel Cubas
 * Author URI: https://qoding.com.br
 */

function inserir_disclaimer_cookies() {
    // Obtém o domínio do site
    $site_domain = parse_url(get_site_url(), PHP_URL_HOST);
    $local_storage_key = 'disclaimerAceitoCookies_' . md5($site_domain);
    ?>
    <div id="qod-cookies" style="bottom:0; display:none;">
        <div class="qod-close" tabindex="0" role="button" aria-label="close-dialog">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
        </div>
        <div>
            <h4>Gerenciar Consentimento de Cookies</h4>
            <p>Para fornecer as melhores experiências, usamos tecnologias como cookies para armazenar e/ou acessar informações do dispositivo. O consentimento para essas tecnologias nos permitirá processar dados como comportamento de navegação ou IDs exclusivos neste site. Não consentir ou retirar o consentimento pode afetar negativamente certos recursos e funções.</p>
            <div class="qod-buttons">
                <button class="qod-accept" onclick="aceitarDisclaimer()">Aceitar</button>
                <button class="qod-denied" onclick="negarDisclaimer()">Negar</button>
            </div>
            <?php
                $privacy_policy_url = get_privacy_policy_url();
                if ( ! empty( $privacy_policy_url ) ) {
                    $policy_page_id     = (int) get_option( 'wp_page_for_privacy_policy' );
                    $policy_page_title  = get_the_title( $policy_page_id );
                    echo '<div class="qod-links"><a href="' . esc_url( $privacy_policy_url ) . '" target="_blank">'.$policy_page_title.'</a></div>';
                }
            ?>
        </div>
    </div>
    <div id="qod-show" style="display:none;">Gerenciar o consentimento</div>

    <script>
        var localStorageKey = "<?php echo esc_js($local_storage_key); ?>";

        document.addEventListener('DOMContentLoaded', function() {
            // Verifica se o usuário já aceitou o disclaimer
            if (!localStorage.getItem(localStorageKey)) {
                document.getElementById('qod-cookies').style.display = 'block';
            } else {
                document.getElementById('qod-show').style.display = 'block';
            }
        });

        document.querySelector('.qod-close').addEventListener('click', function() {
            document.getElementById('qod-cookies').style.bottom = '-100%'; // Desliza para baixo para esconder
            document.getElementById('qod-show').style.display = 'block'; // Mostra o botão para reaparecer
        });

        document.getElementById('qod-show').addEventListener('click', function() {
            document.getElementById('qod-cookies').style.bottom = '0'; // Desliza para cima para mostrar
            this.style.display = 'none'; // Esconde o botão de mostrar
        });

        function aceitarDisclaimer() {
            localStorage.setItem(localStorageKey, 'true');
            document.getElementById('qod-cookies').style.bottom = '-100%';
            document.getElementById('qod-show').style.display = 'block'; // Mostra o botão para reaparecer
        }

        function negarDisclaimer() {
            localStorage.removeItem(localStorageKey);
            document.getElementById('qod-cookies').style.bottom = '-100%';
            document.getElementById('qod-show').style.display = 'block'; // Mostra o botão para reaparecer
        }
    </script>
    <?php
}
add_action('wp_footer', 'inserir_disclaimer_cookies');

function estilos_disclaimer() {
    wp_enqueue_style('estilos-disclaimer-cookies', plugin_dir_url(__FILE__) . 'estilos-disclaimer.css');
}
add_action('wp_enqueue_scripts', 'estilos_disclaimer');
