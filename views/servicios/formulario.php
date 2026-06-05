<div class="campo">
    <label for="nombre">Nombre</label>
    <input
        type="text"
        id="nombre"
        placeholder="Nombre Servicio"
        name="nombre"
        value="<?php echo $servicio->nombre ?>">
</div>

<div class="campo ">
    <label for="categoria">Categoría </label>
    <select
        class="formulario_select"
        id="categoria"
        name="categoriaId">
        <option value="">-- Seleccionar --</option>
        <?php foreach ($categorias as $categoria) { ?>
            <option <?php echo ($servicio->categoriaId === $categoria->id) ? 'selected' : ''; ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
        <?php } ?>
    </select>
</div>

<div class="campo ">
    <label for="detalle">Detalle</label>
    <textarea
        id="detalle"
        name="detalle"
        placeholder="Detalle del servicio"
        rows="2"><?php echo $detallesupdate->detalle ?? ''; ?></textarea>
</div>

<div class="campo">
    <label for="tiempo">Tiempo Estimado</label>
    <input
    class="tiempo"
    type="number"
    id="tiempo"
    name="tiempo"
    min="10"
    placeholder="Tiempo en minutos"
    value="<?php echo $detallesupdate->tiempo ?? ''; ?>"
    >
    <span>Minutos</span>
</div>

<div class="campo">
    <label for="recomendaciones">Consejos</label>
    <textarea
        id="recomendaciones"
        name="recomendaciones"
        placeholder="Recomendaciones del servicio"
        rows="2"
        ><?php echo $detallesupdate->recomendaciones ?? ''; ?></textarea>
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input
        type="number"
        id="precio"
        placeholder="Precio Servicio"
        name="precio"
        value="<?php echo $servicio->precio ?>">
</div>

<div class="campo ">
    <label for="categoria" class="formulario__label">Estado</label>
    <div class="formulario__radio">
        <?php foreach($estados as $estado) {  ?>
            <div>
                <label for="<?php echo strtolower($estado->estado); ?>"><?php echo $estado->estado; ?></label>
                <input 
                    type="radio"
                    id="<?php echo strtolower($estado->estado); ?>"
                    name="estadoId"
                    value="<?php echo $estado->id; ?>"
                    <?php echo ($servicio->estadoId === $estado->id) ? 'checked' : ''; ?>
                >
            </div>
        <?php } ?>
    </div>
</div>

<div class="campo ">
    <label for="categoria" class="formulario__label">Tipo de pago</label>
    <div class="formulario__radio">
        <?php foreach($tipospagos as $tipopago) {  ?>
            <div>
                <label for="<?php echo strtolower($tipopago->nombre); ?>"><?php echo $tipopago->nombre; ?></label>
                <input 
                    type="radio"
                    id="<?php echo strtolower($tipopago->nombre); ?>"
                    name="tipopagoId"
                    value="<?php echo $tipopago->id; ?>"
                    <?php echo ($servicio->tipopagoId === $tipopago->id) ? 'checked' : ''; ?>
                >
            </div>
        <?php } ?>
    </div>
</div>