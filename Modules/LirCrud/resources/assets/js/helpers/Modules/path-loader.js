import fs from 'fs/promises';
import path from 'path';

async function pathLoader(paths, modulesPath) {
  modulesPath = path.join(__dirname, '../../../../../../../'+modulesPath);

  const moduleStatusesPath = path.join(__dirname, '../../../../../../../modules_statuses.json');
  let resolvelists = [];

  try {
    // Read module_statuses.json
    const moduleStatusesContent = await fs.readFile(moduleStatusesPath, 'utf-8');
    const moduleStatuses = JSON.parse(moduleStatusesContent);

    // Read module directories
    const moduleDirectories = await fs.readdir(modulesPath);


    for (const moduleDir of moduleDirectories) {
      if (moduleDir === '.DS_Store') {
        // Skip .DS_Store directory
        continue;
      }

      // Check if the module is enabled (status is true)
      if (moduleStatuses[moduleDir] === true) {
        const viteConfigPath = path.join(modulesPath, moduleDir, 'vite.config.js');
          // Import the module-specific Vite configuration
          const moduleConfig = await import(viteConfigPath);

          // pushItems(moduleConfig, paths, resolvelists)

          resolvelists = Object.assign(
            resolvelists,
            {[`@/Modules/${moduleDir}`]: `/Modules/${moduleDir}/resources/assets/js`}
          )

          if (moduleConfig.alias && moduleConfig.alias instanceof Object) {
            resolvelists = Object.assign(
              resolvelists,
              moduleConfig.alias
            )
          }

          if (moduleConfig.paths && Array.isArray(moduleConfig.paths)) {
            paths.push(...moduleConfig.paths)
          }
      }
    }
  } catch (error) {
    console.error(`Error reading module statuses or module configurations: ${error}`);
  }
  
  return {paths, resolvelists};
}

export default pathLoader;