<head>
    <title> Gerar Relatório</title>
    <script type="text/javascript">
        function formata_data(obj) {
            switch (obj.value.length) {
                case 2:
                    obj.value = obj.value + "-";
                    break;
                case 5:
                    obj.value = obj.value + "-";
                    break;
                case 10:
                    break;
            }
        }

        function Apenas_Numeros(caracter) {
            var nTecla = 0;
            if (document.all) {
                nTecla = caracter.keyCode;
            } else {
                nTecla = caracter.which;
            }
            if ((nTecla > 47 && nTecla < 58) ||
                nTecla == 8 || nTecla == 127 ||
                nTecla == 0 || nTecla == 9 // 0 == Tab
                ||
                nTecla == 13) { // 13 == Enter
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Gerar relatórios do serviço</center>
            </div>
            <div class="panel-body">
                <form id="form_gerar_ralatorio_servico" method="POST">

                    <center>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="control-label">Serviço do dia</label>
                                <input name="doDia" type="text" class="form-control" style="display: inline; width:200px" required onKeyPress="formata_data(this);return Apenas_Numeros(event);" size="11" maxlength="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="margin-top:20px">
                                <label class="control-label">Gerar relatório </label>
                                <select class="form-group form-control" name="acao" style="display: inline; width:200px">
                                    <option value="Selecione"><?php echo "Selecione qual pdf gerar"; ?></option>
                                    <option value="gerar_relatorio_scmt">Ao SCMT</option>
                                    <option value="gerar_relatorio_fiscal_adm">Ao Fiscal Adm</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" id="btn_gerar_ralatorio_servico" class="btn btn-info form-control" style="display: inline; width:300px">Gerar PDF</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>