CREATE TABLE IF NOT EXISTS `._DB_PREFIX_.xml` (
  `id_promocion` int(15) NOT NULL AUTO_INCREMENT,
  `id_shop` int(3) NOT NULL,
  `delay` int(10) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `date_desde` datetime NOT NULL,
  `date_hasta` datetime NOT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_promocion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `._DB_PREFIX_.xml_lang` (
  `id_promocion` int(3) NOT NULL,
  `id_lang` int(3) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  PRIMARY KEY (`id_promocion`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;