function validarFormVazio(formulario){
		dados=$('#' + formulario).serialize();
		d=dados.split('&');
		vazios=0;

		var qtdNegVRegex = /\d\,\d{2}$/;

		for(i=0;i< d.length;i++){
			controles=d[i].split("=");

			if(controles[1]=="A" || controles[1]===""){
				return vazios = vazios +1;
			}else{
				var padraoVet = null;
				var erro = null;
				if(!controles[0] == "tipoMov") {
					var valor = document.getElementById(controles[0]).value;
					switch (controles[0]) {
						case 'qtdNegV':
							padraoVet = [qtdNegVRegex];
							erro = 'Quantidade negociada inserida incorretamente. \n' +
								' Utilize ","(virgula) para separador de casas decimais. \n' +
								' Preencha as casas decimais, respeitando a quantidade de \n' +
								' duas casas decimais. (Ex.: 123456,00 ou 1234,88)'
							break;
						default:
							break;
					}
				}

				if (padraoVet != null) {
					for (j = 0; j < padraoVet.length; j++) {
						var padrao = padraoVet[j];
						if (!padrao.test(valor)) {
							alert(erro);
							return vazios = 1990;
						}
					}
				}
			}
		}
		return vazios;
	}