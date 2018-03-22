-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-05-2015 a las 16:32:56
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `comanderbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `imagenCategoria` varchar(50) DEFAULT 'sinImagen.png',
  `estadoCategoria` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombreCategoria`, `imagenCategoria`, `estadoCategoria`) VALUES
(30, 'Bebida', 'bebidas.png', 1),
(31, 'Comida', 'comida.jpg', 1),
(33, 'Postres', 'postres.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandas`
--

CREATE TABLE IF NOT EXISTS `comandas` (
  `idComanda` int(11) NOT NULL AUTO_INCREMENT,
  `idMesaComanda` int(11) NOT NULL,
  `idPedidoComanda` int(11) NOT NULL,
  `idUsuarioComanda` int(11) NOT NULL,
  `idProductoComanda` int(11) NOT NULL,
  `cantidadPedidaComanda` int(11) NOT NULL,
  `cantidadPreparadaComanda` int(11) NOT NULL DEFAULT '0',
  `cantidadEntregaComanda` int(11) NOT NULL DEFAULT '0',
  `totalComanda` double NOT NULL,
  `estadoComentarioComanda` tinyint(1) DEFAULT '0',
  `comentarioComanda` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `horaComandaPedida` time NOT NULL,
  `horaComandaEnviada` time DEFAULT NULL,
  `horaComandaPreparada` time DEFAULT NULL,
  `horaComandaEntregada` time DEFAULT NULL,
  `estadoPedirComanda` tinyint(1) NOT NULL DEFAULT '0',
  `estadoPreparadoComanda` int(11) DEFAULT '0',
  `estadoCerradoComanda` int(11) DEFAULT '0',
  `envioComanda` int(11) NOT NULL,
  `idMenuProductosComanda` int(11) DEFAULT NULL,
  `idSubmenuProductosComanda` int(11) DEFAULT NULL,
  `idGrupoMenuComanda` int(11) DEFAULT NULL,
  PRIMARY KEY (`idComanda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `comandas`
--

INSERT INTO `comandas` (`idComanda`, `idMesaComanda`, `idPedidoComanda`, `idUsuarioComanda`, `idProductoComanda`, `cantidadPedidaComanda`, `cantidadPreparadaComanda`, `cantidadEntregaComanda`, `totalComanda`, `estadoComentarioComanda`, `comentarioComanda`, `horaComandaPedida`, `horaComandaEnviada`, `horaComandaPreparada`, `horaComandaEntregada`, `estadoPedirComanda`, `estadoPreparadoComanda`, `estadoCerradoComanda`, `envioComanda`, `idMenuProductosComanda`, `idSubmenuProductosComanda`, `idGrupoMenuComanda`) VALUES
(1, 3, 2, 5, 17, 1, 1, 1, 0, 1, 'Muslo', '12:32:00', '12:32:00', NULL, NULL, 1, 1, 1, 3, 4, 1, 11061),
(2, 3, 2, 5, 13, 1, 1, 1, 3, 0, NULL, '12:32:00', '12:32:00', '12:34:00', '12:36:00', 1, 1, 1, 3, 4, 8, 11061),
(3, 3, 2, 5, 18, 1, 1, 1, 0, 0, NULL, '12:32:00', '12:32:00', NULL, NULL, 1, 1, 1, 3, 4, 9, 11061),
(4, 3, 2, 5, 20, 1, 1, 1, 2.5, 0, NULL, '12:32:00', '12:32:00', NULL, '12:36:00', 1, 1, 1, 0, 4, 10, 11061),
(5, 3, 2, 5, 21, 1, 1, 1, 1.6, 0, NULL, '12:32:00', '12:32:00', NULL, '12:36:00', 1, 1, 1, 4, 4, 11, 11061),
(6, 3, 2, 5, 14, 3, 3, 3, 5.4, 0, NULL, '12:36:00', '12:36:00', NULL, NULL, 1, 1, 1, 4, NULL, NULL, NULL),
(7, 3, 2, 5, 14, 2, 2, 2, 3.6, 1, 'Sal', '12:38:00', '12:38:00', NULL, '12:38:00', 1, 1, 1, 4, NULL, NULL, NULL),
(9, 6, 4, 4, 29, 1, 1, 1, 0, 0, NULL, '13:04:00', '13:04:00', NULL, '13:06:00', 1, 1, 0, 3, 6, 14, 26001),
(10, 6, 4, 4, 15, 1, 1, 1, 1.8, 0, NULL, '13:04:00', '13:04:00', NULL, '13:06:00', 1, 1, 0, 4, 6, 15, 26001),
(11, 1, 5, 5, 11, 1, 1, 1, 0, 0, NULL, '13:04:00', '13:04:00', NULL, NULL, 1, 1, 1, 3, 6, 14, 24017),
(12, 1, 5, 5, 21, 1, 1, 1, 1.6, 0, NULL, '13:04:00', '13:04:00', NULL, '13:06:00', 1, 1, 1, 4, 6, 15, 24017),
(13, 6, 4, 4, 29, 3, 3, 3, 0, 0, NULL, '14:25:00', '14:25:00', NULL, '14:38:00', 1, 1, 0, 3, NULL, NULL, NULL),
(28, 1, 10, 5, 11, 1, 1, 1, 0, 0, NULL, '16:59:00', '16:59:00', NULL, NULL, 1, 1, 1, 3, 6, 14, 13197),
(29, 1, 10, 5, 14, 1, 1, 1, 0, 0, NULL, '16:59:00', '16:59:00', NULL, NULL, 1, 1, 1, 4, 6, 15, 13197),
(32, 2, 12, 5, 17, 1, 1, 1, 0, 0, NULL, '11:27:00', '11:27:00', NULL, NULL, 1, 1, 0, 3, 5, 6, 28822),
(33, 2, 12, 5, 34, 1, 1, 1, 0, 0, NULL, '11:27:00', '11:27:00', NULL, NULL, 1, 1, 0, 3, 5, 12, 28822),
(34, 2, 12, 5, 27, 1, 1, 1, 0, 0, NULL, '11:28:00', '11:28:00', NULL, NULL, 1, 1, 0, 3, 5, 13, 28822),
(35, 6, 4, 4, 31, 2, 2, 2, 6, 0, NULL, '00:51:00', '00:51:00', '01:01:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(36, 6, 4, 4, 29, 2, 2, 2, 5, 0, NULL, '01:05:00', '01:05:00', '01:06:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(37, 2, 12, 5, 11, 1, 1, 1, 3, 1, 'Gfhghhh', '23:46:00', '23:46:00', '23:47:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(38, 2, 12, 5, 25, 2, 2, 2, 13, 0, NULL, '23:50:00', '23:50:00', '12:46:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(39, 6, 4, 4, 30, 2, 2, 2, 5.2, 0, NULL, '23:51:00', '23:51:00', '23:51:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(40, 6, 4, 4, 26, 1, 1, 1, 4.3, 0, NULL, '12:49:00', '12:49:00', '12:49:00', NULL, 1, 1, 0, 3, NULL, NULL, NULL),
(41, 2, 12, 5, 20, 1, 1, 1, 2.5, 0, NULL, '13:08:00', '13:08:00', NULL, '13:10:00', 1, 1, 0, 0, NULL, NULL, NULL),
(42, 2, 12, 5, 27, 1, 1, 1, 3.8, 0, NULL, '13:08:00', '13:08:00', '13:09:00', '13:10:00', 1, 1, 0, 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `nombreMenu` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `precioMenu` float NOT NULL,
  `estadoMenu` tinyint(4) NOT NULL DEFAULT '1',
  `idTipomenu` int(11) NOT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`idMenu`, `nombreMenu`, `precioMenu`, `estadoMenu`, `idTipomenu`) VALUES
(4, 'Menu Fin de semana', 20, 1, 1),
(5, 'Menu Noche', 12.5, 1, 1),
(6, 'Bocadillo del dia', 3.6, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE IF NOT EXISTS `mesas` (
  `idMesa` int(11) NOT NULL AUTO_INCREMENT,
  `nombreMesa` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `idUsuarioMesa` int(11) DEFAULT NULL,
  `estadoMesa` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idMesa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`idMesa`, `nombreMesa`, `idUsuarioMesa`, `estadoMesa`) VALUES
(1, '1', NULL, 0),
(2, '2', 5, 1),
(3, '3', NULL, 0),
(4, '4', NULL, 0),
(5, '5', NULL, 0),
(6, '6', 4, 1),
(7, '7', NULL, 0),
(8, '8', NULL, 0),
(9, '9', NULL, 0),
(10, '10', NULL, 0),
(11, '11', NULL, 0),
(12, '12', NULL, 0),
(13, '13', NULL, 0),
(14, '14', NULL, 0),
(15, '15', NULL, 0),
(16, '16', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `idMesaPedido` int(11) NOT NULL,
  `estadoMesaPedido` int(11) NOT NULL DEFAULT '1',
  `idUsuarioPedido` int(11) NOT NULL,
  `estadoCobroPedido` tinyint(1) DEFAULT '0',
  `importePedido` double DEFAULT '0',
  `horaCobroPedido` time DEFAULT NULL,
  `fechaPedido` date NOT NULL,
  `horaPedido` time DEFAULT NULL,
  `fechaHoraPedidio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `idMesaPedido`, `estadoMesaPedido`, `idUsuarioPedido`, `estadoCobroPedido`, `importePedido`, `horaCobroPedido`, `fechaPedido`, `horaPedido`, `fechaHoraPedidio`) VALUES
(2, 3, 0, 5, 1, 29, '13:08:00', '2015-04-04', '12:31:00', '2015-04-04 10:31:56'),
(4, 6, 1, 4, 0, 0, NULL, '2015-04-04', '13:01:00', '2015-04-04 11:01:38'),
(5, 1, 0, 5, 1, 3.6, '13:06:00', '2015-04-04', '13:04:00', '2015-04-04 11:04:48'),
(10, 1, 0, 5, 1, 3.6, '16:59:00', '2015-04-05', '16:58:00', '2015-04-05 14:58:45'),
(12, 2, 1, 5, 0, 0, NULL, '2015-04-12', '11:27:00', '2015-04-12 09:27:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `idCategoriaProducto` int(11) NOT NULL,
  `idSubcategoriaProducto` int(11) NOT NULL,
  `imagenProducto` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT 'sinImagen.png',
  `precioVentaProducto` double DEFAULT NULL,
  `precioCompraProducto` double DEFAULT NULL,
  `estadoProducto` tinyint(1) NOT NULL DEFAULT '1',
  `stockProducto` double DEFAULT NULL,
  `descripcionProducto` varchar(500) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `envioProducto` int(11) NOT NULL,
  `idMenuProducto` int(11) DEFAULT NULL,
  `idSubmenuProducto` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `idCategoriaProducto`, `idSubcategoriaProducto`, `imagenProducto`, `precioVentaProducto`, `precioCompraProducto`, `estadoProducto`, `stockProducto`, `descripcionProducto`, `envioProducto`, `idMenuProducto`, `idSubmenuProducto`) VALUES
(10, 'Copa de coñac', 30, 21, 'cognac.jpg', 1, 1, 1, 10, 'CoÃ±ac de varias marcas', 4, NULL, NULL),
(11, 'Bocadillo de chorizo', 31, 22, 'bocadillo-chorizo.jpg', 3, 1.5, 1, 100, 'Bocadillo de chorizo', 3, NULL, NULL),
(13, 'Sopa de pollo', 30, 26, 'sopaPollo.jpg', 3, 1.5, 1, 10, 'Sopa de pollo con variedad de verduras.', 3, NULL, NULL),
(14, 'Zumo de tomate', 30, 27, 'zumoTomate.jpg', 1.8, 8, 1, 50, 'Zumo de tomate.                        ', 4, NULL, NULL),
(15, 'Zumo de melocotón', 30, 27, 'zumoMelocoton.jpg', 1.8, 0.8, 1, 50, 'Zumo de melocotÃ³n.', 4, NULL, NULL),
(17, 'Ensalada variada', 31, 28, 'ensalada.jpg', 15, 10, 1, 10, 'Ensalada variada compuesta de lechuga , cebolla, tomate, olivas negras, olivas verdes, atun.', 3, NULL, NULL),
(18, 'Pollo a la brasa', 31, 20, 'polloBrasa.jpg', 5, 3, 1, 10, 'Pollo a la brasa con patatas de guarniciÃ³n', 3, NULL, NULL),
(19, 'Bistec a la plancha', 30, 20, 'bistec.jpg', 10, 5, 1, 10, 'Bistec a la plancha con patatas de guarniciÃ³n', 3, NULL, NULL),
(20, 'platano', 33, 33, 'platanos.jpg', 2.5, NULL, 1, NULL, NULL, 0, NULL, NULL),
(21, 'Vino de la casa', 30, 31, 'vinocasa.jpg', 1.6, NULL, 1, NULL, NULL, 4, NULL, NULL),
(24, 'Atun a la plancha', 31, 30, 'atunplancha.jpg', 8.2, 4.5, 1, NULL, 'Atun a la plancha', 3, NULL, NULL),
(25, 'Sopa de pescado', 31, 26, 'sopapescado.jpg', 6.5, 3, 1, 2, 'Exquisita sopa de pescado       ', 3, NULL, NULL),
(26, 'Ensalada Cesar', 31, 28, 'ensaladacesar.jpg', 4.3, 2, 1, 5, 'Ensalada Cesar                   ', 3, NULL, NULL),
(27, 'Salchichas', 31, 20, 'salchichas.jpg', 3.8, 2, 1, 10, 'Salchichas con guarniciÃ³n de patatas o ensalada', 3, NULL, NULL),
(29, 'bocadillo de jamon', 31, 22, 'bocadillojamon.jpg', 2.5, NULL, 1, NULL, '            ', 3, NULL, NULL),
(30, 'Hamburguesa', 31, 22, 'hamburguesa.jpg', 2.6, NULL, 1, NULL, '      Con o sin queso      ', 3, NULL, NULL),
(31, 'Caldo Gallego', 31, 26, 'caldogallego.jpg', 3, NULL, 1, NULL, '            ', 3, NULL, NULL),
(32, 'CocaCola', 30, 29, 'cocacola.jpg', 1.4, 1.4, 1, NULL, '            ', 3, NULL, NULL),
(33, 'Fanta', 30, 29, 'fanta.jpg', 1.6, NULL, 1, NULL, '            ', 3, NULL, NULL),
(34, 'Spaghetis', 31, 34, 'spaghetis.jpg', 2.4, NULL, 1, NULL, '    Bolognesa o Carbonara        ', 3, NULL, NULL),
(35, 'Vino tinto', 30, 35, 'vinotinto.jpg', 1.2, NULL, 1, NULL, '          Vino tinto\r\nPrecio por copa', 3, NULL, NULL),
(36, 'Vino blanco', 30, 35, 'vinoblanco.jpg', 1.2, NULL, 1, NULL, '         Precio por copa   ', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosmenu`
--

CREATE TABLE IF NOT EXISTS `productosmenu` (
  `idProductosMenu` int(11) NOT NULL AUTO_INCREMENT,
  `idProducto` int(11) DEFAULT NULL,
  `idMenu` int(11) DEFAULT NULL,
  `idSubmenu` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProductosMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `productosmenu`
--

INSERT INTO `productosmenu` (`idProductosMenu`, `idProducto`, `idMenu`, `idSubmenu`) VALUES
(1, 17, 4, 1),
(2, 13, 4, 8),
(3, 18, 4, 9),
(4, 19, 4, 9),
(5, 20, 4, 10),
(6, 21, 4, 11),
(7, 14, 4, 11),
(8, 11, 6, 14),
(9, 14, 6, 15),
(10, 15, 6, 15),
(11, 21, 6, 15),
(13, 29, 6, 14),
(14, 34, 4, 8),
(15, 34, 5, 12),
(16, 31, 5, 12),
(17, 17, 5, 6),
(18, 26, 5, 6),
(19, 24, 5, 13),
(20, 27, 5, 13),
(21, 19, 5, 13),
(22, 30, 6, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pruebacomander`
--

CREATE TABLE IF NOT EXISTS `pruebacomander` (
  `idPruebaComander` int(11) NOT NULL AUTO_INCREMENT,
  `fechaInicioPruebaComander` date NOT NULL,
  `fechaFinPruebaComander` date NOT NULL,
  `clavePruebaPruebaComander` int(11) NOT NULL DEFAULT '0',
  `fechaActivacionPruebaComander` date NOT NULL,
  `claveComanderPruebaComander` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idPruebaComander`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `pruebacomander`
--

INSERT INTO `pruebacomander` (`idPruebaComander`, `fechaInicioPruebaComander`, `fechaFinPruebaComander`, `clavePruebaPruebaComander`, `fechaActivacionPruebaComander`, `claveComanderPruebaComander`) VALUES
(1, '2015-02-18', '2015-03-20', 1424217600, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE IF NOT EXISTS `subcategorias` (
  `idSubcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreSubcategoria` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `idCategoriaSubcategoria` int(11) NOT NULL,
  `imagenSubcategoria` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT 'sinImagen.pgn',
  `estadoSubcategoria` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idSubcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`idSubcategoria`, `nombreSubcategoria`, `idCategoriaSubcategoria`, `imagenSubcategoria`, `estadoSubcategoria`) VALUES
(20, 'Carnes', 31, 'carnes.jpg', 1),
(21, 'Licores', 30, 'portafolio-licores.png', 1),
(22, 'Bocadillos', 31, 'bocadillos.jpg', 1),
(26, 'Sopas', 31, 'sopa.jpg', 1),
(27, 'Zumos', 30, 'zumos.jpg', 1),
(28, 'Ensaladas', 31, 'ensaladas.jpg', 1),
(29, 'Refrescos', 30, 'refrescos.jpg', 1),
(30, 'Pescados', 31, 'pescados.jpg', 1),
(33, 'Frutas', 33, 'frutas.jpg', 1),
(34, 'Pastas', 31, 'pasta.jpg', 1),
(35, 'Vinos', 30, 'vinos.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submenus`
--

CREATE TABLE IF NOT EXISTS `submenus` (
  `idSubmenu` int(11) NOT NULL AUTO_INCREMENT,
  `nombreSubmenu` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `idMenuSubmenu` int(11) NOT NULL,
  `estadoSubmenu` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idSubmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `submenus`
--

INSERT INTO `submenus` (`idSubmenu`, `nombreSubmenu`, `idMenuSubmenu`, `estadoSubmenu`) VALUES
(1, 'Entrante', 4, 1),
(5, 'Bebida', 3, 1),
(6, 'Entrante', 5, 1),
(8, 'Primero', 4, 1),
(9, 'Segundo', 4, 1),
(10, 'Postre', 4, 1),
(11, 'Bebida', 4, 1),
(12, 'Primero', 5, 1),
(13, 'segundo', 5, 1),
(14, 'Bocadillo', 6, 1),
(15, 'Bebida', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomenu`
--

CREATE TABLE IF NOT EXISTS `tipomenu` (
  `idTipomenu` int(11) NOT NULL AUTO_INCREMENT,
  `nombreTipomenu` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idTipomenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipomenu`
--

INSERT INTO `tipomenu` (`idTipomenu`, `nombreTipomenu`) VALUES
(1, 'MENU'),
(2, 'OFERTA'),
(3, 'iyuiuyiuy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nickUsuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `passwordUsuario` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `nombreUsuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `apellidosUsuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `puestoUsuario` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `imagenUsuario` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL DEFAULT 'sinImagen.png',
  `nivelPermisoUsuario` int(11) NOT NULL,
  `claveUsuario` varchar(20) NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nickUsuario`, `passwordUsuario`, `nombreUsuario`, `apellidosUsuario`, `puestoUsuario`, `imagenUsuario`, `nivelPermisoUsuario`, `claveUsuario`) VALUES
(1, 'ADMINISTRADOR', 'COMANDER', '', '', '', '', 1, ''),
(2, 'NEREA', 'SANTOS', '', '', '', '', 1, ''),
(3, 'AINARA', 'SANTOS', '', '', '', '', 2, ''),
(4, 'peter', '1234', 'Pedro', 'garcia', 'Developer', '', 1, 'pepe'),
(5, 'cristian', '1234', 'Cristian', 'Santos', 'Developer', '', 1, 'wewe'),
(10, 'prueba2', 'dddds2', 'ssdsd2', 'sddsd2', 'dsdsdsd2', 'IMG_20141004_110144.jpg', 3, ''),
(11, 'prueba', '1111', 'prueba', 'comander', 'prueba', 'sinImagen.png', 2, ''),
(12, 'antonio', '1234', 'Antonio', 'Garcia', 'Camarero', 'sinImagen.png', 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE IF NOT EXISTS `zonas` (
  `idZona` int(11) NOT NULL AUTO_INCREMENT,
  `nombreZona` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `ModificarZona` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idZona`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`idZona`, `nombreZona`, `ModificarZona`) VALUES
(3, 'Cocina', 1),
(4, 'Barra', 1),
(6, 'Parrilla', 1),
(7, 'Coctelería', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
