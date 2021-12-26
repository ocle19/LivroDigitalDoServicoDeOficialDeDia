$("#btn_logar").click(function (event) {
    event.preventDefault();
    var data = new FormData($('#form_login')[0]);
    $("#btn_logar").html('Verificando...');
    $("#btn_logar").attr("disabled", true);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerUsuario.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        beforeSend: function () {

        },

        success: function (result) {
            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                $("#btn_logar").html('Conectando...');
                window.location.href = resultado.irpara
                $("#btn_logar").attr("disabled", false);

            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 1500
                })
                Swal.hideLoading()
                $("#btn_logar").html('Entrar');
                $("#btn_logar").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            new Swal('Oops!', '' + e.responseTex + '', 'error');
            $("#btn_logar").attr("disabled", false);
            Swal.hideLoading()
        }

    });
});

$("#btn_cadastrar_servico").click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_cadastrar_servico')[0]);
    $("#btn_cadastrar_servico").html('Verificando...');
    $("#btn_cadastrar_servico").attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerServico.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            $("#btn_cadastrar_servico").html('Registrando...');
            Swal.showLoading()
        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: 'Serviço adicionado com sucesso, agora confira o serviço e avise o OF de Dia!',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                window.location.href = resultado.irpara
                $("#btn_cadastrar_servico").attr("disabled", false);
                $("#btn_cadastrar_servico").html('Registrar a 1ª parte do SV');
                Swal.hideLoading()
            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                Swal.hideLoading()
                $("#btn_cadastrar_servico").html('Registrar a 1ª parte do SV');
                $("#btn_cadastrar_servico").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            console.log(e);
            $("#btn_cadastrar_servico").attr("disabled", false);
            Swal.hideLoading()
        }

    });
});

$("#btn_alterar_servico").click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_alterar_servico')[0]);
    $("#btn_alterar_servico").html('Verificando...');
    $("#btn_alterar_servico").attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerServico.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            $("#btn_alterar_servico").html('Salvando...');
            Swal.showLoading()
        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: 'Dados do serviço alterados com sucesso!',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                /// window.location.href = resultado.irpara
                $("#btn_alterar_servico").attr("disabled", false);
                $("#btn_alterar_servico").html('Alterar dados do serviço');
                Swal.hideLoading()
            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                Swal.hideLoading()
                $("#btn_alterar_servico").html('Alterar dados do serviço');
                $("#btn_alterar_servico").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            Swal.fire({
                title: 'Oops',
                text: 'Ocorreu um erro! Tente novamente',
                icon: 'error',
                showConfirmButton: false,
                timer: 2500
            })
            $("#btn_alterar_servico").attr("disabled", false);
        }

    });
});

$("#btn_passar_servico").click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_passar_servico')[0]);
    $("#btn_passar_servico").html('Verificando...');
    $("#btn_passar_servico").attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerServico.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            $("#btn_passar_servico").html('Registrando...');
            Swal.showLoading()
        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: 'Serviço passado com sucesso!!!\n Baixe, imprima e leve ao Scmt e ao Fiscal Adm.',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                for (var i = 0; i < document.getElementById('doDia').options.length; i++) {
                    if (document.getElementById('doDia').options[i].value == resultado.doDia) {
                        document.getElementById('doDia').options[i].remove()
                        break;
                    }
                }
                document.getElementById('passeiAo').selectedIndex = 0
                $("#btn_passar_servico").attr("disabled", false);
                $("#btn_passar_servico").html('Fechar e passar serviço');
                Swal.hideLoading()
            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                Swal.hideLoading()
                $("#btn_passar_servico").html('Fechar e passar serviço');
                $("#btn_passar_servico").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            console.log(e);
            $("#btn_passar_servico").attr("disabled", false);
            Swal.hideLoading()
        }

    });
});

$("#btn_voltar_servico").click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_voltar_servico')[0]);
    $("#btn_voltar_servico").html('Verificando...');
    $("#btn_voltar_servico").attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerServico.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            $("#btn_voltar_servico").html('Verificando...');
            Swal.showLoading()
        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: 'O serviço voltou para o estado de edição!',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                for (var i = 0; i < document.getElementById('doDia').options.length; i++) {
                    if (document.getElementById('doDia').options[i].value == resultado.doDia) {
                        document.getElementById('doDia').options[i].remove()
                        break;
                    }
                }
                $("#btn_voltar_servico").attr("disabled", false);
                $("#btn_voltar_servico").html('Voltar o serviço ao modo edição');
                Swal.hideLoading()
            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                Swal.hideLoading()
                $("#btn_voltar_servico").html('Voltar o serviço ao modo edição');
                $("#btn_voltar_servico").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            console.log(e);
            $("#btn_voltar_servico").attr("disabled", false);
            Swal.hideLoading()
        }

    });
});

$("#btn_adicionar_adjunto").click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_adicionar_adjunto')[0]);
    $("#btn_adicionar_adjunto").html('Verificando...');
    $("#btn_adicionar_adjunto").attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerServico.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            $("#btn_adicionar_adjunto").html('Verificando...');
            Swal.showLoading()
        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: 'Adjunto adicionado ao serviço',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                for (var i = 0; i < document.getElementById('doDia').options.length; i++) {
                    if (document.getElementById('doDia').options[i].value == resultado.doDia) {
                        document.getElementById('doDia').options[i].remove()
                        break;
                    }
                }
                document.getElementById('adj').selectedIndex = 0
                $("#btn_adicionar_adjunto").attr("disabled", false);
                $("#btn_adicionar_adjunto").html('Adicionar');
                Swal.hideLoading()
            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 2500
                })
                Swal.hideLoading()
                $("#btn_adicionar_adjunto").html('Adicionar');
                $("#btn_adicionar_adjunto").attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            console.log(e);
            $("#btn_adicionar_adjunto").attr("disabled", false);
            Swal.hideLoading()
        }

    });
});
const btn_trocar_senha = $("#btn_trocar_senha") ?? 0;
btn_trocar_senha.click(function (event) {
    event.preventDefault();
    var data = new FormData($('#form_trocar_senha')[0]);
    btn_trocar_senha.html('Verificando...');
    btn_trocar_senha.prop("disabled", true);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerUsuario.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {

        },

        success: function (result) {

            var resultado = JSON.parse(result);
            if ($.trim(resultado.mensagem) === "ok") {
                btn_trocar_senha.html('Verificando...');
                btn_trocar_senha.prop("disabled", false);

            } else {
                Swal.fire({
                    title: '' + resultado.resposta + '',
                    text: '' + resultado.mensagem + '',
                    icon: '' + resultado.status + '',
                    showConfirmButton: false,
                    timer: 1500
                })
                Swal.hideLoading()
                btn_trocar_senha.html('Alterar senha');
                btn_trocar_senha.prop("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            new Swal('Oops!', '' + e.responseTex + '', 'error');
            btn_trocar_senha.prop("disabled", false);
            Swal.hideLoading()
        }

    });
});

const btn_gerar_relatorio_servico = $("#btn_gerar_ralatorio_servico") ?? 0
btn_gerar_relatorio_servico.click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_gerar_ralatorio_servico')[0]);
    btn_gerar_relatorio_servico.html('Verificando...');
    btn_gerar_relatorio_servico.prop("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerRelatorio.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            btn_gerar_relatorio_servico.html('Gerando...');
            Swal.showLoading()
        },

        success: function (result) {

            try {
                var resultado = JSON.parse(result);
                if ($.trim(resultado.mensagem) === "ok") {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: 'PDF Gerado!',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    window.open(resultado.pdf);
                    btn_gerar_relatorio_servico.prop("disabled", false);
                    btn_gerar_relatorio_servico.html('Gerar PDF');
                    Swal.hideLoading()
                } else {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: '' + resultado.mensagem + '',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    Swal.hideLoading()
                    btn_gerar_relatorio_servico.html('Gerar PDF');
                    btn_gerar_relatorio_servico.prop("disabled", false);
                }
            } catch {
                Swal.fire({
                    title: 'Oops',
                    text: 'Ocorreu um erro! Tente novamente',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2500
                })
                btn_gerar_relatorio_servico.prop("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
            btn_gerar_relatorio_servico.html('Gerar PDF');
        },

        error: function (e) {
            btn_gerar_relatorio_servico.prop("disabled", false);
            Swal.hideLoading()
        }

    });
});

const btn_cadastrar_usuario = $("#btn_cadastrar_usuario") ?? 0
btn_cadastrar_usuario.click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_cadastrar_usuario')[0]);
    btn_cadastrar_usuario.html('Verificando...');
    btn_cadastrar_usuario.prop("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerUsuario.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            btn_cadastrar_usuario.html('Verificando...');
            Swal.showLoading()
        },

        success: function (result) {

            try {
                var resultado = JSON.parse(result);
                if ($.trim(resultado.mensagem) === "ok") {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: 'Usuário cadastrado!',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    btn_cadastrar_usuario.prop("disabled", false);
                    btn_cadastrar_usuario.html('Cadastrar usuário');
                    Swal.hideLoading()
                } else {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: '' + resultado.mensagem + '',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    Swal.hideLoading()
                    btn_cadastrar_usuario.html('Cadastrar usuário');
                    btn_cadastrar_usuario.prop("disabled", false);
                }
            } catch {
                Swal.fire({
                    title: 'Oops',
                    text: 'Ocorreu um erro! Tente novamente',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2500
                })
                btn_cadastrar_usuario.prop("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
            btn_cadastrar_usuario.html('Cadastrar usuário');
        },

        error: function (e) {
            btn_cadastrar_usuario.prop("disabled", false);
            Swal.fire({
                title: 'Oops',
                text: 'Ocorreu um erro! Tente novamente',
                icon: 'error',
                showConfirmButton: false,
                timer: 2500
            })
        }

    });
});

const btn_editar_usuario = $("#btn_editar_usuario") ?? 0
btn_editar_usuario.click(function (event) {
    Swal.showLoading()
    event.preventDefault();
    var data = new FormData($('#form_editar_usuario')[0]);
    btn_editar_usuario.html('Verificando...');
    btn_editar_usuario.prop("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerUsuario.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {
            btn_editar_usuario.html('Verificando...');
            Swal.showLoading()
        },

        success: function (result) {

            try {
                var resultado = JSON.parse(result);
                if ($.trim(resultado.mensagem) === "ok") {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: 'Dados alterados!',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    btn_editar_usuario.prop("disabled", false);
                    btn_editar_usuario.html('Salvar');
                    Swal.hideLoading()
                } else {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: '' + resultado.mensagem + '',
                        icon: '' + resultado.status + '',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    Swal.hideLoading()
                    btn_editar_usuario.html('Salvar');
                    btn_editar_usuario.prop("disabled", false);
                }
            } catch {
                Swal.fire({
                    title: 'Oops',
                    text: 'Ocorreu um erro! Tente novamente',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2500
                })
                btn_editar_usuario.prop("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
            btn_editar_usuario.html('Salvar');
        },

        error: function (e) {
            btn_editar_usuario.prop("disabled", false);
            Swal.fire({
                title: 'Oops',
                text: 'Ocorreu um erro! Tente novamente',
                icon: 'error',
                showConfirmButton: false,
                timer: 2500
            })
        }

    });
});

const btn_cadastrar_punicao = $("#btn_cadastrar_punicao") ?? 0
btn_cadastrar_punicao.click(function (event) {
    Swal.showLoading();
    event.preventDefault();
    var serializedData = $("#form_cadastrar_punicao").serialize();
    $(btn_cadastrar_punicao).html('Verificando...');
    $(btn_cadastrar_punicao).attr("disabled", true);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "acoes/controllerPunicoes.php",
        data: serializedData,
        processData: false,
        cache: false,
        timeout: 600000,

        beforeSend: function () {

        },

        success: function (result) {
            try {
                var resultado = JSON.parse(result);
                if ($.trim(resultado.mensagem) === "ok") {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: 'Punição cadastrada!',
                        icon: '' + resultado.status + '',
                        showConfirmButton: true,
                        timer: 500
                    })
                    listarPunicoesDoDia(resultado.dia)
                    $(btn_cadastrar_punicao).html('Adicionar punição');
                    $(btn_cadastrar_punicao).attr("disabled", false);
                } else {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: '' + resultado.mensagem + '',
                        icon: '' + resultado.status + '',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    $(btn_cadastrar_punicao).html('Adicionar punição');
                    $(btn_cadastrar_punicao).attr("disabled", false);
                    Swal.hideLoading()
                }
            } catch (e) {
                Swal.fire({
                    title: 'Oops',
                    text: 'Ocorreu algum problema!' + e,
                    icon: 'error',
                    showConfirmButton: true,
                    timer: 500
                })
                $(btn_cadastrar_punicao).html('Adicionar punição');
                $(btn_cadastrar_punicao).attr("disabled", false);
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            new Swal('Oops!', '' + e.responseTex + '', 'error');
            $(btn_cadastrar_punicao).html('Adicionar punição');
            $(btn_cadastrar_punicao).attr("disabled", false);
            Swal.hideLoading()
        }

    });
})

function deletarPunicao(punicao) {
    Swal.showLoading();
    let data = {
        'acao': 'deletar_punicao',
        'punicao': punicao
    };
    $.ajax({
        type: "POST",
        url: "acoes/controllerPunicoes.php",
        data: data,
        cache: false,
        timeout: 600000,

        beforeSend: function () {

        },

        success: function (result) {
            try {
                var resultado = JSON.parse(result);
                if ($.trim(resultado.mensagem) === "ok") {
                    $('#punicao' + punicao).remove()
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: 'Punição deletada!',
                        icon: '' + resultado.status + '',
                        showConfirmButton: true,
                        timer: 500
                    })
                } else {
                    Swal.fire({
                        title: '' + resultado.resposta + '',
                        text: '' + resultado.mensagem + '',
                        icon: '' + resultado.status + '',
                        showConfirmButton: true,
                        timer: 1500
                    })
                    Swal.hideLoading()
                }
            } catch (e) {
                new Swal('Oops!', 'Ocorreu algum erro!', 'error');
            }
        },

        complete: function () {
            Swal.hideLoading()
        },

        error: function (e) {
            new Swal('Oops!', '' + e.responseTex + '', 'error');
            btn.prop("disabled", false);
            Swal.hideLoading()
        }

    });
}
function listarPunicoesDoDia(dia) {
    let data = {
        'acao': 'listar_punidos_do_dia',
        'doDia': dia
    };
    $.ajax({
        type: "POST",
        url: "acoes/controllerPunicoes.php",
        data: data,
        cache: false,
        timeout: 600000,

        beforeSend: function () {

        },

        success: function (result) {
            try {
                document.getElementById('punidosDoDia').innerHTML = result
            } catch (e) {
                new Swal('Oops!', 'Ocorreu algum erro!', 'error');
            }
        },

        complete: function () {
        },

        error: function (e) {
            new Swal('Oops!', '' + e.responseTex + '', 'error');
            btn.prop("disabled", false);
            Swal.hideLoading()
        }

    });
}

$("input[type=password]").keyup(function () {
    if (document.getElementById('nova_senha').value.length > 0) {
        if (document.getElementById('nova_senha').value === document.getElementById('nova_senha_r').value) {
            $("#erro_repeticao_senha").css("display", "block");
            $("#pwmatch").removeClass("glyphicon-remove");
            $("#pwmatch").addClass("glyphicon-ok");
            $("#pwmatch").css("color", "#00A41E");
            $("#txtpwmatch").html("As senhas conferem!")
        } else {
            $("#erro_repeticao_senha").css("display", "block");
            $("#pwmatch").removeClass("glyphicon-ok");
            $("#pwmatch").addClass("glyphicon-remove");
            $("#pwmatch").css("color", "#FF0004");
            $("#txtpwmatch").html("As senhas <b>NÃO</b> conferem!")
        }
    }
});