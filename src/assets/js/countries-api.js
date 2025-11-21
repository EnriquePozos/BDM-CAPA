/**
 * Servicio para consumir REST Countries API
 * Proporciona lista de países y gentilicios
 */

class CountriesAPI {
    constructor() {
        this.apiURL = 'https://restcountries.com/v3.1/all?fields=name,demonyms,cca2';
        this.cacheKey = 'countries_cache';
        this.cacheExpiry = 24 * 60 * 60 * 1000; // 24 horas en milisegundos
        this.countries = [];
    }

    /**
     * Obtiene los países desde la API o desde caché
     */
async fetchCountries() {
    // Verificar si hay datos en caché válidos
    const cached = this.getFromCache();
    if (cached) {
        this.countries = cached;
        return cached;
    }

    try {
        const response = await fetch(this.apiURL);
        if (!response.ok) {
            throw new Error('Error al obtener países');
        }

        const data = await response.json();
        
        // Diccionario de traducción inglés → español
        const traducciones = this.getTraduccionesEspanol();
        
        // Procesar y ordenar datos CON TRADUCCIÓN
        this.countries = data
            .map(country => {
                const nombreIngles = country.name.common;
                const traduccion = traducciones[nombreIngles];
                
                return {
                    name: traduccion?.nombre || nombreIngles,
                    official: traduccion?.oficial || country.name.official,
                    demonym: traduccion?.gentilicio || country.demonyms?.eng?.m || 'Habitante',
                    code: country.cca2
                };
            })
            .sort((a, b) => a.name.localeCompare(b.name, 'es'));

        // Guardar en caché
        this.saveToCache(this.countries);
        
        return this.countries;

    } catch (error) {
        console.error('Error al cargar países:', error);
        return this.getFallbackCountries();
    }
}

/**
 * Diccionario de traducciones de países al español
 */
getTraduccionesEspanol() {
    return {
        // América
        'Mexico': { nombre: 'México', oficial: 'Estados Unidos Mexicanos', gentilicio: 'Mexicano' },
        'United States': { nombre: 'Estados Unidos', oficial: 'Estados Unidos de América', gentilicio: 'Estadounidense' },
        'Canada': { nombre: 'Canadá', oficial: 'Canadá', gentilicio: 'Canadiense' },
        'Argentina': { nombre: 'Argentina', oficial: 'República Argentina', gentilicio: 'Argentino' },
        'Brazil': { nombre: 'Brasil', oficial: 'República Federativa del Brasil', gentilicio: 'Brasileño' },
        'Chile': { nombre: 'Chile', oficial: 'República de Chile', gentilicio: 'Chileno' },
        'Colombia': { nombre: 'Colombia', oficial: 'República de Colombia', gentilicio: 'Colombiano' },
        'Peru': { nombre: 'Perú', oficial: 'República del Perú', gentilicio: 'Peruano' },
        'Venezuela': { nombre: 'Venezuela', oficial: 'República Bolivariana de Venezuela', gentilicio: 'Venezolano' },
        'Ecuador': { nombre: 'Ecuador', oficial: 'República del Ecuador', gentilicio: 'Ecuatoriano' },
        'Bolivia': { nombre: 'Bolivia', oficial: 'Estado Plurinacional de Bolivia', gentilicio: 'Boliviano' },
        'Paraguay': { nombre: 'Paraguay', oficial: 'República del Paraguay', gentilicio: 'Paraguayo' },
        'Uruguay': { nombre: 'Uruguay', oficial: 'República Oriental del Uruguay', gentilicio: 'Uruguayo' },
        'Costa Rica': { nombre: 'Costa Rica', oficial: 'República de Costa Rica', gentilicio: 'Costarricense' },
        'Panama': { nombre: 'Panamá', oficial: 'República de Panamá', gentilicio: 'Panameño' },
        'Cuba': { nombre: 'Cuba', oficial: 'República de Cuba', gentilicio: 'Cubano' },
        'Dominican Republic': { nombre: 'República Dominicana', oficial: 'República Dominicana', gentilicio: 'Dominicano' },
        'Guatemala': { nombre: 'Guatemala', oficial: 'República de Guatemala', gentilicio: 'Guatemalteco' },
        'Honduras': { nombre: 'Honduras', oficial: 'República de Honduras', gentilicio: 'Hondureño' },
        'El Salvador': { nombre: 'El Salvador', oficial: 'República de El Salvador', gentilicio: 'Salvadoreño' },
        'Nicaragua': { nombre: 'Nicaragua', oficial: 'República de Nicaragua', gentilicio: 'Nicaragüense' },
        
        // Europa
        'Spain': { nombre: 'España', oficial: 'Reino de España', gentilicio: 'Español' },
        'France': { nombre: 'Francia', oficial: 'República Francesa', gentilicio: 'Francés' },
        'Germany': { nombre: 'Alemania', oficial: 'República Federal de Alemania', gentilicio: 'Alemán' },
        'Italy': { nombre: 'Italia', oficial: 'República Italiana', gentilicio: 'Italiano' },
        'United Kingdom': { nombre: 'Reino Unido', oficial: 'Reino Unido de Gran Bretaña e Irlanda del Norte', gentilicio: 'Británico' },
        'Portugal': { nombre: 'Portugal', oficial: 'República Portuguesa', gentilicio: 'Portugués' },
        'Netherlands': { nombre: 'Países Bajos', oficial: 'Reino de los Países Bajos', gentilicio: 'Neerlandés' },
        'Belgium': { nombre: 'Bélgica', oficial: 'Reino de Bélgica', gentilicio: 'Belga' },
        'Switzerland': { nombre: 'Suiza', oficial: 'Confederación Suiza', gentilicio: 'Suizo' },
        'Austria': { nombre: 'Austria', oficial: 'República de Austria', gentilicio: 'Austriaco' },
        'Greece': { nombre: 'Grecia', oficial: 'República Helénica', gentilicio: 'Griego' },
        'Poland': { nombre: 'Polonia', oficial: 'República de Polonia', gentilicio: 'Polaco' },
        'Sweden': { nombre: 'Suecia', oficial: 'Reino de Suecia', gentilicio: 'Sueco' },
        'Norway': { nombre: 'Noruega', oficial: 'Reino de Noruega', gentilicio: 'Noruego' },
        'Denmark': { nombre: 'Dinamarca', oficial: 'Reino de Dinamarca', gentilicio: 'Danés' },
        'Finland': { nombre: 'Finlandia', oficial: 'República de Finlandia', gentilicio: 'Finlandés' },
        'Ireland': { nombre: 'Irlanda', oficial: 'República de Irlanda', gentilicio: 'Irlandés' },
        'Russia': { nombre: 'Rusia', oficial: 'Federación de Rusia', gentilicio: 'Ruso' },
        
        // Asia
        'China': { nombre: 'China', oficial: 'República Popular China', gentilicio: 'Chino' },
        'Japan': { nombre: 'Japón', oficial: 'Estado de Japón', gentilicio: 'Japonés' },
        'South Korea': { nombre: 'Corea del Sur', oficial: 'República de Corea', gentilicio: 'Surcoreano' },
        'India': { nombre: 'India', oficial: 'República de la India', gentilicio: 'Indio' },
        'Thailand': { nombre: 'Tailandia', oficial: 'Reino de Tailandia', gentilicio: 'Tailandés' },
        'Vietnam': { nombre: 'Vietnam', oficial: 'República Socialista de Vietnam', gentilicio: 'Vietnamita' },
        'Philippines': { nombre: 'Filipinas', oficial: 'República de Filipinas', gentilicio: 'Filipino' },
        'Indonesia': { nombre: 'Indonesia', oficial: 'República de Indonesia', gentilicio: 'Indonesio' },
        'Malaysia': { nombre: 'Malasia', oficial: 'Malasia', gentilicio: 'Malayo' },
        'Singapore': { nombre: 'Singapur', oficial: 'República de Singapur', gentilicio: 'Singapurense' },
        
        // Oceanía
        'Australia': { nombre: 'Australia', oficial: 'Mancomunidad de Australia', gentilicio: 'Australiano' },
        'New Zealand': { nombre: 'Nueva Zelanda', oficial: 'Nueva Zelanda', gentilicio: 'Neozelandés' },
        
        // África
        'South Africa': { nombre: 'Sudáfrica', oficial: 'República de Sudáfrica', gentilicio: 'Sudafricano' },
        'Egypt': { nombre: 'Egipto', oficial: 'República Árabe de Egipto', gentilicio: 'Egipcio' },
        'Morocco': { nombre: 'Marruecos', oficial: 'Reino de Marruecos', gentilicio: 'Marroquí' },
        'Nigeria': { nombre: 'Nigeria', oficial: 'República Federal de Nigeria', gentilicio: 'Nigeriano' },
        'Kenya': { nombre: 'Kenia', oficial: 'República de Kenia', gentilicio: 'Keniano' }
    };
}
    /**
     * Obtiene datos del caché si están disponibles y no han expirado
     */
    getFromCache() {
        try {
            const cached = localStorage.getItem(this.cacheKey);
            if (!cached) return null;

            const { data, timestamp } = JSON.parse(cached);
            const now = new Date().getTime();

            // Verificar si el caché ha expirado
            if (now - timestamp > this.cacheExpiry) {
                localStorage.removeItem(this.cacheKey);
                return null;
            }

            return data;
        } catch (error) {
            return null;
        }
    }

    /**
     * Guarda datos en caché
     */
    saveToCache(data) {
        try {
            const cacheData = {
                data: data,
                timestamp: new Date().getTime()
            };
            localStorage.setItem(this.cacheKey, JSON.stringify(cacheData));
        } catch (error) {
            console.warn('No se pudo guardar en caché:', error);
        }
    }

    /**
     * Lista de países de respaldo en caso de error de API
     */
    getFallbackCountries() {
        return [
            { name: 'México', demonym: 'Mexicano', code: 'MX' },
            { name: 'Estados Unidos', demonym: 'Estadounidense', code: 'US' },
            { name: 'España', demonym: 'Español', code: 'ES' },
            { name: 'Argentina', demonym: 'Argentino', code: 'AR' },
            { name: 'Brasil', demonym: 'Brasileño', code: 'BR' },
            { name: 'Colombia', demonym: 'Colombiano', code: 'CO' },
            { name: 'Chile', demonym: 'Chileno', code: 'CL' },
            { name: 'Perú', demonym: 'Peruano', code: 'PE' },
            { name: 'Venezuela', demonym: 'Venezolano', code: 'VE' },
            { name: 'Ecuador', demonym: 'Ecuatoriano', code: 'EC' }
        ].sort((a, b) => a.name.localeCompare(b.name, 'es'));
    }

    /**
     * Llena un select con la lista de países
     */
    async populateCountrySelect(selectElement, selectedValue = '') {
        const countries = await this.fetchCountries();
        
        // Limpiar opciones existentes excepto la primera (placeholder)
        selectElement.innerHTML = '<option value="">Selecciona un país</option>';

        // Agregar países como opciones
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name;
            option.textContent = country.name;
            option.dataset.demonym = country.demonym;
            
            // Seleccionar si coincide con el valor previo
            if (selectedValue && country.name === selectedValue) {
                option.selected = true;
            }
            
            selectElement.appendChild(option);
        });
    }

    /**
     * Obtiene el gentilicio de un país específico
     */
    getDemonymByCountry(countryName) {
        const country = this.countries.find(c => c.name === countryName);
        return country ? country.demonym : '';
    }
}

/**
 * Inicializar automáticamente cuando el DOM esté listo
 */
document.addEventListener('DOMContentLoaded', function() {
    const countriesAPI = new CountriesAPI();

    // Buscar el select de país de nacimiento
    const paisNacimientoSelect = document.getElementById('pais_nacimiento');
    const nacionalidadInput = document.getElementById('nacionalidad');

    if (paisNacimientoSelect && nacionalidadInput) {
        // Guardar valor previo si existe (para edición de perfil)
        const valorPrevio = paisNacimientoSelect.value || paisNacimientoSelect.dataset.value;
        
        // Llenar el select con países
        countriesAPI.populateCountrySelect(paisNacimientoSelect, valorPrevio);

        // Auto-completar nacionalidad cuando se selecciona un país
        paisNacimientoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const demonym = selectedOption.dataset.demonym;
            
            if (demonym && nacionalidadInput) {
                nacionalidadInput.value = demonym;
            }
        });

        // Si ya hay un país seleccionado, llenar la nacionalidad
        if (valorPrevio) {
            setTimeout(() => {
                const selectedOption = paisNacimientoSelect.options[paisNacimientoSelect.selectedIndex];
                if (selectedOption && selectedOption.dataset.demonym && !nacionalidadInput.value) {
                    nacionalidadInput.value = selectedOption.dataset.demonym;
                }
            }, 100);
        }
    }
});