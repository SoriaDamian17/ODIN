CREATE TABLE IF NOT EXISTS `._DB_PREFIX_.tarjetas` (
  `codigotarjeta` int(15) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `numerocomercio` varchar(30) NOT NULL,
  `paymentCod` int(3) NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`codigotarjeta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `._DB_PREFIX_.planes_tarjetas` (
  `idPlanestarjetas` int(3) NOT NULL AUTO_INCREMENT,
  `codigotarjeta` varchar(15) NOT NULL,
  `tarjeta` varchar(45) NOT NULL,
  `planestarjeta` varchar(50) NOT NULL,
  `cantidadcuotas` int(2) NOT NULL,
  `coeficiente` int(10) NOT NULL,
  `coeficienteespecial` double NOT NULL,
  `coeficientecuota` double NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fechahoravigenciadesde` datetime NOT NULL,
  `fechahoravigenciahasta` datetime NOT NULL,
  PRIMARY KEY (`idPlanestarjetas`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;