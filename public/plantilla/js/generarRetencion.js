var form = document.getElementById('xmlForm');

function p_comprobar_numero_cedula(cedula) {

    if (typeof (cedula) == 'string' && cedula.length == 10 && /^\d+$/.test(cedula)) {
        var digitos = cedula.split('').map(Number);
        var codigo_provincia = digitos[0] * 10 + digitos[1];

        if (codigo_provincia >= 1 && codigo_provincia <= 24 && digitos[2] < 6) {
            var digito_verificador = digitos.pop();

            var digito_calculado = digitos.reduce(function (valorPrevio, valorActual, indice) {
                return valorPrevio - (valorActual * (2 - indice % 2)) % 9 - (valorActual == 9) * 9;
            }, 1000) % 10;

            return (digito_calculado === digito_verificador);
        }
    }
    return false;
}


function p_calcular_digito_modulo11(numero) {
    var digito_calculado = -1;

    if (typeof (numero) == 'string' && /^\d+$/.test(numero)) {

        var digitos = numero.split('').map(Number); //arreglo con los dígitos del número

        digito_calculado = 11 - digitos.reduce(function (valorPrevio, valorActual, indice) {
            return valorPrevio + (valorActual * (7 - indice % 6));
        }, 0) % 11;

        digito_calculado = (digito_calculado == 11) ? 0 : digito_calculado; //según ficha técnica
        digito_calculado = (digito_calculado == 10) ? 1 : digito_calculado; //según ficha técnica
    }
    return digito_calculado;
}


var p_obtener_secuencial = (function (tipo_comprobante) {

    function getRandomInt() {
        return Math.floor(Math.random() * (10000)) + 1;
    }

    tipo_comprobante = tipo_comprobante || 0;

    var secuencial = {
        0: 1,
        1: 2,
        4: 1,
        5: 1,
        6: 1,
        7: 1
    };
    return function () {
        return secuencial[tipo_comprobante]++;
        //return getRandomInt();
    }
})();


function p_obtener_codigo_autorizacion_desde_comprobante(comprobante) {
    var tipoComprobante = Object.keys(comprobante)[0];

    var codigoAutorizacion = p_obtener_codigo_autorizacion(
        moment(comprobante[tipoComprobante].infoCompRetencion.fechaEmision, 'DD/MM/YYYY'), //fechaEmision
        tipoComprobante,//tipoComprobante
        comprobante[tipoComprobante].infoTributaria.ruc,//ruc
        comprobante[tipoComprobante].infoTributaria.ambiente,//ambiente
        comprobante[tipoComprobante].infoTributaria.estab,//estab
        comprobante[tipoComprobante].infoTributaria.ptoEmi,//ptoEmi
        comprobante[tipoComprobante].infoTributaria.secuencial,//secuencial
        null,//codigo
        comprobante[tipoComprobante].infoTributaria.tipoEmision//tipoEmision
    );

    return codigoAutorizacion;
}

function p_obtener_codigo_autorizacion(fechaEmision, tipoComprobante, ruc, ambiente, estab, ptoEmi, secuencial, codigo, tipoEmision) {
    fechaEmision = fechaEmision || new Date();
    tipoComprobante = tipoComprobante || 'factura'; //1 factura, 4 nota de crédito, 5 nota de débito, 6 guía de remisión, 7 retención
    ruc = ruc || '9999999999999';
    ambiente = ambiente || 1; // 1 pruebas, 2 produccion

    //serie = serie || 0;
    estab = estab || 1;
    ptoEmi = ptoEmi || 1;


    secuencial = secuencial || p_obtener_secuencial(tipoComprobante);
    codigo = codigo || (moment(fechaEmision).format('DDMM') + pad(secuencial, 4).slice(-3) + p_calcular_digito_modulo11(moment(fechaEmision).format('DDMM') + pad(secuencial, 3).slice(-3)));
    tipoEmision = tipoEmision || 1; //1 emision normal

    var codigo_autorizacion = moment(fechaEmision).format('DDMMYYYY')
        + pad(codDoc[tipoComprobante], 2)
        + pad(ruc, 13)
        + pad(ambiente, 1)
        + pad(estab, 3) + pad(ptoEmi, 3)
        + pad(secuencial, 9)
        + pad(codigo, 8)
        + pad(tipoEmision, 1);

    var digito_calculado = p_calcular_digito_modulo11(codigo_autorizacion);

    if (digito_calculado > -1) {
        return codigo_autorizacion + digito_calculado;
    }
}

function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}


var codDoc = {
    'factura': 1,
    'comprobanteRetencion': 7,
    'guiaRemision': 6,
    'notaCredito': 4,
    'notaDebito': 5,
};

//console.log('codigo autorizacion: ', p_obtener_codigo_autorizacion().length);

function p_generar_factura_xml() {

    var rucUniversidad = document.getElementById("ruc_universidad").value;
    var razonSocialUniversidad = document.getElementById("razon_social_universidad").value;
    var tipo_documento_factura = document.getElementById("tipo_documento").value;
    var establecimiento_factura = document.getElementById("establecimiento_venta").value;
    var punto_emision_factura = document.getElementById("punto_emision_venta").value;
    var secuencial_factura = document.getElementById("codigo_venta").value;
    var direccion_matriz_universidad = document.getElementById("direccion_matriz_universidad").value;
    var descripcion_factura = document.getElementById("descripcion").value;

    var estructuraFactura = {
        comprobanteRetencion: {
            _id: "comprobante",
            _version: "2.0.0",
            infoTributaria: {
                ambiente: null,
                tipoEmision: null,
                razonSocial: null,
                nombreComercial: null,
                ruc: null,
                claveAcceso: null,
                codDoc: null,
                estab: null,
                ptoEmi: null,
                secuencial: null,
                dirMatriz: null,
                agenteRetencion: null
            },
            infoCompRetencion: {
                fechaEmision: null,
                obligadoContabilidad: null,
                tipoIdentificacionSujetoRetenido: null,
                parteRel: null,
                razonSocialSujetoRetenido: null,
                identificacionSujetoRetenido: null,
                periodoFiscal: null,
            },
            docsSustento: {
                docSustento: [
                    {
                        codSustento: null, 
                        codDocSustento: null, 
                        numDocSustento: null,
                        fechaEmisionDocSustento: null,
                        numAutDocSustento: null,
                        pagoLocExt: null,
                        totalSinImpuestos: null,
                        importeTotal: null,

                        impuestosDocSustento: {
                            impuestoDocSustento: [
                            ]
                        },
                        retenciones: {
                            retencion: [
                            ]
                        },
                        pagos: {
                            pago: [
                            ]
                        },
                    }
                ]
            },
            infoAdicional: {
                campoAdicional: [
                    {
                        _nombre: "Detalles Adicionales",
                        __text: descripcion_factura
                    }
                    //<campoAdicional nombre="Codigo Impuesto ISD">4580</campoAdicional> //Obligatorio cuando corresponda
                    //<campoAdicional nombre="Impuesto ISD">15.42x</campoAdicional> //Obligatorio cuando corresponda
                ]
            }
        }
    };

    var tipoComprobante = 'comprobanteRetencion';
    var estab = 1;
    var ptoEmi = 1;

    estructuraFactura[tipoComprobante].infoTributaria.ambiente = 1; //1 pruebas, 2 produccion
    estructuraFactura[tipoComprobante].infoTributaria.tipoEmision = 1; //1 emision normal
    estructuraFactura[tipoComprobante].infoTributaria.razonSocial = razonSocialUniversidad;
    estructuraFactura[tipoComprobante].infoTributaria.nombreComercial = razonSocialUniversidad;
    estructuraFactura[tipoComprobante].infoTributaria.ruc = rucUniversidad;
    estructuraFactura[tipoComprobante].infoTributaria.claveAcceso = ''; //se lo llena más abajo
    estructuraFactura[tipoComprobante].infoTributaria.codDoc = tipo_documento_factura; //tipo de comprobante
    estructuraFactura[tipoComprobante].infoTributaria.estab = establecimiento_factura;
    estructuraFactura[tipoComprobante].infoTributaria.ptoEmi = punto_emision_factura;
    estructuraFactura[tipoComprobante].infoTributaria.secuencial = secuencial_factura;
    estructuraFactura[tipoComprobante].infoTributaria.dirMatriz = direccion_matriz_universidad;

    estructuraFactura[tipoComprobante].infoCompRetencion.fechaEmision = moment().format('DD/MM/YYYY');
    estructuraFactura[tipoComprobante].infoCompRetencion.obligadoContabilidad = 'NO';
    estructuraFactura[tipoComprobante].infoCompRetencion.tipoIdentificacionSujetoRetenido = '02';
    estructuraFactura[tipoComprobante].infoCompRetencion.parteRel = 'NO';
    estructuraFactura[tipoComprobante].infoCompRetencion.razonSocialSujetoRetenido = 'LO QUE SEA';
    estructuraFactura[tipoComprobante].infoCompRetencion.identificacionSujetoRetenido = '1722904701';
    estructuraFactura[tipoComprobante].infoCompRetencion.periodoFiscal = '04/2024';
    
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].codDoc = '01';
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].codDocSustento = '1';
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].numDocSustento = '000000226';
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].fechaEmisionDocSustento = moment().format('DD/MM/YYYY');
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].numAutDocSustento = '2203202401180313732000110010010000002262203226914';
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].pagoLocExt = '01';
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].totalSinImpuestos = 2041.67;
    estructuraFactura[tipoComprobante].docsSustento.docSustento[0].importeTotal = 2041.67;

    //pagos

    estructuraFactura[tipoComprobante].infoTributaria.claveAcceso = p_obtener_codigo_autorizacion_desde_comprobante(estructuraFactura);

    //document.getElementById('claveAcceso').value = p_obtener_codigo_autorizacion_desde_comprobante(estructuraFactura);

    var x2js = new X2JS({ useDoubleQuotes: true });

    var xmlAsStr = '<?xml version="1.0" encoding="UTF-8"?>\n';
    xmlAsStr += x2js.json2xml_str(estructuraFactura);

    return xmlAsStr;
}

var path = ""

function generarXml() {
    xmlData = generarRetencion();
    return xmlData;
}


function generarRetencion() {
    xmlData = p_generar_factura_xml();
    document.getElementById('xmlContent').value = xmlData;
    return xmlData;
}


function sha1_base64(txt) {
    var md = forge.md.sha1.create();
    md.update(txt);
    var hexDigest = md.digest().toHex();
    // Convertir hexadecimal a Uint8Array
    //var uint8Array = new Uint8Array(hexDigest.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
    var BUFFER = new window.buffer.Buffer(hexDigest, "hex");
    var Base64 = BUFFER.toString("base64");

    // Crear una cadena Base64
    //var base64String = btoa(String.fromCharCode.apply(null, uint8Array));
    return Base64;
}

function p_generar_xades_bes(factura, callback) {
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(factura, "text/xml");
    var claveAcceso = xmlDoc.getElementsByTagName("claveAcceso")[0].childNodes[0].nodeValue;
    var contenidoFirma = '';
    var pwdCert = document.getElementById('claveFirma').value;
    var fileInput = document.getElementById('p12File');
    var file = fileInput.files[0];

    generarFirma(file, factura, pwdCert, function (firma, certificado, modulus, firma_pem, certificado_pem, modulus_pem,
        certificateX509_der_hash, X509SerialNumber, exponent, issuerName) {

        var sha1_factura = sha1_base64(factura.replace('<?xml version="1.0" encoding="UTF-8"?>\n', ''));

        var xmlns = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';


        //numeros involucrados en los hash:
        var Certificate_number = p_obtener_aleatorio(); //1562780 en el ejemplo del SRI
        var Signature_number = p_obtener_aleatorio(); //620397 en el ejemplo del SRI
        var SignedProperties_number = p_obtener_aleatorio(); //24123 en el ejemplo del SRI

        //numeros fuera de los hash:
        var SignedInfo_number = p_obtener_aleatorio(); //814463 en el ejemplo del SRI
        var SignedPropertiesID_number = p_obtener_aleatorio(); //157683 en el ejemplo del SRI
        var Reference_ID_number = p_obtener_aleatorio(); //363558 en el ejemplo del SRI
        var SignatureValue_number = p_obtener_aleatorio(); //398963 en el ejemplo del SRI
        var Object_number = p_obtener_aleatorio(); //231987 en el ejemplo del SRI

        var SignedProperties = '';

        SignedProperties += '<etsi:SignedProperties Id="Signature' + Signature_number + '-SignedProperties' + SignedProperties_number + '">';  //SignedProperties
        SignedProperties += '<etsi:SignedSignatureProperties>';
        SignedProperties += '<etsi:SigningTime>';

        SignedProperties += moment().format('YYYY-MM-DD\THH:mm:ssZ');

        SignedProperties += '</etsi:SigningTime>';
        SignedProperties += '<etsi:SigningCertificate>';
        SignedProperties += '<etsi:Cert>';
        SignedProperties += '<etsi:CertDigest>';
        SignedProperties += '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
        SignedProperties += '</ds:DigestMethod>';
        SignedProperties += '<ds:DigestValue>';

        SignedProperties += certificateX509_der_hash;

        SignedProperties += '</ds:DigestValue>';
        SignedProperties += '</etsi:CertDigest>';
        SignedProperties += '<etsi:IssuerSerial>';
        SignedProperties += '<ds:X509IssuerName>';
        SignedProperties += issuerName;
        SignedProperties += '</ds:X509IssuerName>';
        SignedProperties += '<ds:X509SerialNumber>';

        SignedProperties += X509SerialNumber;

        SignedProperties += '</ds:X509SerialNumber>';
        SignedProperties += '</etsi:IssuerSerial>';
        SignedProperties += '</etsi:Cert>';
        SignedProperties += '</etsi:SigningCertificate>';
        SignedProperties += '</etsi:SignedSignatureProperties>';
        SignedProperties += '<etsi:SignedDataObjectProperties>';
        SignedProperties += '<etsi:DataObjectFormat ObjectReference="#Reference-ID-' + Reference_ID_number + '">';
        SignedProperties += '<etsi:Description>';

        SignedProperties += 'contenido comprobante';

        SignedProperties += '</etsi:Description>';
        SignedProperties += '<etsi:MimeType>';
        SignedProperties += 'text/xml';
        SignedProperties += '</etsi:MimeType>';
        SignedProperties += '</etsi:DataObjectFormat>';
        SignedProperties += '</etsi:SignedDataObjectProperties>';
        SignedProperties += '</etsi:SignedProperties>'; //fin SignedProperties


        SignedProperties_para_hash = SignedProperties.replace('<etsi:SignedProperties', '<etsi:SignedProperties ' + xmlns);

        var sha1_SignedProperties = sha1_base64(SignedProperties_para_hash);


        var KeyInfo = '';

        KeyInfo += '<ds:KeyInfo Id="Certificate' + Certificate_number + '">';
        KeyInfo += '\n<ds:X509Data>';
        KeyInfo += '\n<ds:X509Certificate>\n';

        //CERTIFICADO X509 CODIFICADO EN Base64 
        KeyInfo += certificado;

        KeyInfo += '\n</ds:X509Certificate>';
        KeyInfo += '\n</ds:X509Data>';
        KeyInfo += '\n<ds:KeyValue>';
        KeyInfo += '\n<ds:RSAKeyValue>';
        KeyInfo += '\n<ds:Modulus>\n';

        //MODULO DEL CERTIFICADO X509
        KeyInfo += modulus;

        KeyInfo += '\n</ds:Modulus>';
        KeyInfo += '\n<ds:Exponent>';

        //KeyInfo += 'AQAB';
        KeyInfo += exponent;

        KeyInfo += '</ds:Exponent>';
        KeyInfo += '\n</ds:RSAKeyValue>';
        KeyInfo += '\n</ds:KeyValue>';
        KeyInfo += '\n</ds:KeyInfo>';

        KeyInfo_para_hash = KeyInfo.replace('<ds:KeyInfo', '<ds:KeyInfo ' + xmlns);

        var sha1_certificado = sha1_base64(KeyInfo_para_hash);


        var SignedInfo = '';

        SignedInfo += '<ds:SignedInfo Id="Signature-SignedInfo' + SignedInfo_number + '">';
        SignedInfo += '\n<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">';
        SignedInfo += '</ds:CanonicalizationMethod>';
        SignedInfo += '\n<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1">';
        SignedInfo += '</ds:SignatureMethod>';
        SignedInfo += '\n<ds:Reference Id="SignedPropertiesID' + SignedPropertiesID_number + '" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature' + Signature_number + '-SignedProperties' + SignedProperties_number + '">';
        SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
        SignedInfo += '</ds:DigestMethod>';
        SignedInfo += '\n<ds:DigestValue>';

        //HASH O DIGEST DEL ELEMENTO <etsi:SignedProperties>';
        SignedInfo += sha1_SignedProperties;

        SignedInfo += '</ds:DigestValue>';
        SignedInfo += '\n</ds:Reference>';
        SignedInfo += '\n<ds:Reference URI="#Certificate' + Certificate_number + '">';
        SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
        SignedInfo += '</ds:DigestMethod>';
        SignedInfo += '\n<ds:DigestValue>';

        //HASH O DIGEST DEL CERTIFICADO X509
        SignedInfo += sha1_certificado;

        SignedInfo += '</ds:DigestValue>';
        SignedInfo += '\n</ds:Reference>';
        SignedInfo += '\n<ds:Reference Id="Reference-ID-' + Reference_ID_number + '" URI="#comprobante">';
        SignedInfo += '\n<ds:Transforms>';
        SignedInfo += '\n<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature">';
        SignedInfo += '</ds:Transform>';
        SignedInfo += '\n</ds:Transforms>';
        SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
        SignedInfo += '</ds:DigestMethod>';
        SignedInfo += '\n<ds:DigestValue>';

        //HASH O DIGEST DE TODO EL ARCHIVO XML IDENTIFICADO POR EL id="comprobante" 
        SignedInfo += sha1_factura;

        SignedInfo += '</ds:DigestValue>';
        SignedInfo += '\n</ds:Reference>';
        SignedInfo += '\n</ds:SignedInfo>';

        SignedInfo_para_firma = SignedInfo.replace('<ds:SignedInfo', '<ds:SignedInfo ' + xmlns);

        p_firmar(file, SignedInfo_para_firma, pwdCert, function (firma_SignedInfo) {

            var xades_bes = '';


            //INICIO DE LA FIRMA DIGITAL 
            xades_bes += '<ds:Signature ' + xmlns + ' Id="Signature' + Signature_number + '">';
            xades_bes += '\n' + SignedInfo;

            xades_bes += '\n<ds:SignatureValue Id="SignatureValue' + SignatureValue_number + '">\n';

            //VALOR DE LA FIRMA (ENCRIPTADO CON LA LLAVE PRIVADA DEL CERTIFICADO DIGITAL) 
            xades_bes += firma_SignedInfo;

            xades_bes += '\n</ds:SignatureValue>';

            xades_bes += '\n' + KeyInfo;

            xades_bes += '\n<ds:Object Id="Signature' + Signature_number + '-Object' + Object_number + '">';
            xades_bes += '<etsi:QualifyingProperties Target="#Signature' + Signature_number + '">';

            //ELEMENTO <etsi:SignedProperties>';
            xades_bes += SignedProperties;

            xades_bes += '</etsi:QualifyingProperties>';
            xades_bes += '</ds:Object>';
            xades_bes += '</ds:Signature>';

            //FIN DE LA FIRMA DIGITAL 


            callback(factura.replace('</factura>', xades_bes + '</factura>'), claveAcceso);

        });

    });


}

function generarFirma(p12File, infoAFirmar, pwdCert, callback2) {
    var pemMessagep7 = '', certificateX509 = '';

    if (p12File !== undefined && infoAFirmar !== undefined) {
        var reader = new FileReader();
        var arrayBuffer = null;
        var resultReader = null;

        reader.readAsArrayBuffer(p12File);

        reader.onloadend = function () {
            arrayBuffer = reader.result;
            var arrayUint8 = new Uint8Array(arrayBuffer);
            var p12Der = forge.util.decode64(forge.util.binary.base64.encode(arrayUint8));
            var p12Asn1 = forge.asn1.fromDer(p12Der);

            var p12 = null;

            p12 = forge.pkcs12.pkcs12FromAsn1(p12Asn1, pwdCert);

            var certBags = p12.getBags({ bagType: forge.pki.oids.certBag })
            var cert = certBags[forge.oids.certBag][0].cert;
            var pkcs8bags = p12.getBags({ bagType: forge.pki.oids.pkcs8ShroudedKeyBag });
            var pkcs8 = pkcs8bags[forge.oids.pkcs8ShroudedKeyBag][0];
            var key = pkcs8.key;

            if (key == null) {
                key = pkcs8.asn1;
            }

            var md = forge.md.sha1.create();
            md.update(infoAFirmar, 'utf8');
            var signature = btoa(key.sign(md)).match(/.{1,76}/g).join("\n");

            certificateX509_pem = forge.pki.certificateToPem(cert);

            certificateX509 = certificateX509_pem;
            certificateX509 = certificateX509.substr(certificateX509.indexOf('\n'));
            certificateX509 = certificateX509.substr(0, certificateX509.indexOf('\n-----END CERTIFICATE-----'));

            certificateX509 = certificateX509.replace(/\r?\n|\r/g, '').replace(/([^\0]{76})/g, '$1\n');

            //Pasar certificado a formato DER y sacar su hash:
            certificateX509_asn1 = forge.pki.certificateToAsn1(cert);
            certificateX509_der = forge.asn1.toDer(certificateX509_asn1).getBytes();
            certificateX509_der_hash = sha1_base64(certificateX509_der);

            //Serial Number
            var X509SerialNumber = parseInt(cert.serialNumber, 16);

            exponent = hexToBase64(key.e.data[0].toString(16));
            modulus_pem = modulus = bigint2base64(key.n);

            var issuerName = '';
            const issuerAttrs = cert.issuer.attributes;
            issuerName = issuerAttrs.reverse().map(attr => {
                return `${attr.shortName}=${attr.value}`;
            }).join(',');

            callback2(signature, certificateX509, modulus, signature, certificateX509_pem, modulus_pem,
                certificateX509_der_hash, X509SerialNumber, exponent, issuerName);
        }
    } else {
        if ($.isEmptyObject(p12File)) {
            var msg = "Debe seleccionar el archivo de certificado digital (.p12)";
            console.error(msg);
        }

        if ($.isEmptyObject(infoAFirmar)) {
            var msg = "No existe informacion a firmar";
            console.error(msg);
        }
    }

    return pemMessagep7;
}

function bigint2base64(bigint) {
    var base64 = '';
    base64 = btoa(bigint.toString(16).match(/\w{2}/g).map(function (a) { return String.fromCharCode(parseInt(a, 16)); }).join(""));

    base64 = base64.match(/.{1,76}/g).join("\n");

    return base64;
}


function p_firmar(p12File, infoAFirmar, pwdCert, callback) {
    var reader = new FileReader();
    var arrayBuffer = null;
    var resultReader = null;
    var signature = '';

    reader.readAsArrayBuffer(p12File);

    reader.onloadend = function () {
        arrayBuffer = reader.result;
        var arrayUint8 = new Uint8Array(arrayBuffer);
        var p12B64 = forge.util.binary.base64.encode(arrayUint8);
        var p12Der = forge.util.decode64(p12B64);
        var p12Asn1 = forge.asn1.fromDer(p12Der);

        var p12 = null;

        p12 = forge.pkcs12.pkcs12FromAsn1(p12Asn1, pwdCert);

        var pkcs8bags = p12.getBags({ bagType: forge.pki.oids.pkcs8ShroudedKeyBag });
        var pkcs8 = pkcs8bags[forge.oids.pkcs8ShroudedKeyBag][0];
        var key = pkcs8.key;
        if (key == null) {
            key = pkcs8.asn1;
        }


        var md = forge.md.sha1.create();
        md.update(infoAFirmar, 'utf8');
        signature = btoa(key.sign(md)).match(/.{1,76}/g).join("\n");

        callback(signature);
    };

    return;
}
function p_obtener_aleatorio() {
    return Math.floor(Math.random() * 999000) + 990;
}


function hexToBase64(str) {
    var hex = ('00' + str).slice(0 - str.length - str.length % 2);

    return btoa(String.fromCharCode.apply(null,
        hex.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" "))
    );
}
